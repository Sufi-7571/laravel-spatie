<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ValidEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Basic format validation first
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('The email address format is invalid.');
            return;
        }

        $apiKey = config('services.abstractapi.key');

        // Skip API validation if not configured
        if (empty($apiKey) || $apiKey === 'skip') {
            Log::info('AbstractAPI: Skipping - API key not configured');
            return;
        }

        try {
            Log::info('AbstractAPI: Validating email', ['email' => $value]);

            // Using Email Reputation API
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->get('https://emailreputation.abstractapi.com/v1/', [
                    'api_key' => $apiKey,
                    'email' => $value,
                ]);

            Log::info('AbstractAPI: Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Check for API error
                if (isset($data['error'])) {
                    Log::warning('AbstractAPI: Error response', ['error' => $data['error']]);
                    return; // Don't fail on API errors
                }

                // Check email deliverability
                if (isset($data['email_deliverability'])) {
                    $deliverability = $data['email_deliverability'];

                    // Check if format is valid
                    if (isset($deliverability['is_format_valid']) && $deliverability['is_format_valid'] === false) {
                        $fail('The email address format is invalid.');
                        return;
                    }

                    // Check if MX records are valid
                    if (isset($deliverability['is_mx_valid']) && $deliverability['is_mx_valid'] === false) {
                        $fail('The email domain does not have valid mail servers.');
                        return;
                    }

                    // Check if SMTP is valid (email actually exists)
                    if (isset($deliverability['is_smtp_valid']) && $deliverability['is_smtp_valid'] === false) {
                        $fail('The email address does not exist or cannot receive emails.');
                        return;
                    }

                    // Check deliverability status
                    if (isset($deliverability['status'])) {
                        $status = strtolower($deliverability['status']);
                        if (in_array($status, ['undeliverable'])) {
                            $fail('The email address is undeliverable and cannot be used.');
                            return;
                        }
                    }
                }

                // Check if it's a disposable email
                if (isset($data['email_quality']['is_disposable']) && $data['email_quality']['is_disposable'] === true) {
                    $fail('Disposable or temporary email addresses are not allowed.');
                    return;
                }

                // Check email quality score (0.0 - 1.0, lower is worse)
                if (isset($data['email_quality']['score']) && $data['email_quality']['score'] < 0.2) {
                    $fail('This email address has a poor quality score and cannot be used.');
                    return;
                }

                Log::info('AbstractAPI: Email validation passed', ['email' => $value]);

            } else {
                // Log the error but DON'T fail validation
                Log::warning('AbstractAPI: Request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                // Allow registration if API fails (don't block users)
                return;
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('AbstractAPI: Connection error', ['error' => $e->getMessage()]);
            // Allow registration if API is unreachable
            return;

        } catch (\Exception $e) {
            Log::error('AbstractAPI: Unexpected error', ['error' => $e->getMessage()]);
            // Allow registration on unexpected errors
            return;
        }
    }
}