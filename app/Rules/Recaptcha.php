<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secretKey = config('services.recaptcha.secret_key');

        // Skip validation if not configured
        if (!$secretKey || $secretKey === 'skip') {
            Log::info('reCAPTCHA: Skipping - not configured');
            return;
        }

        if (empty($value)) {
            $fail('Please complete the reCAPTCHA verification.');
            return;
        }

        try {
            $response = Http::withoutVerifying() // <-- This fixes the SSL error
                ->timeout(30)
                ->asForm()
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secretKey,
                    'response' => $value,
                    'remoteip' => request()->ip()
                ]);

            if ($response->successful()) {
                $result = $response->json();

                if (!isset($result['success']) || !$result['success']) {
                    Log::warning('reCAPTCHA: Verification failed', [
                        'error-codes' => $result['error-codes'] ?? []
                    ]);
                    $fail('reCAPTCHA verification failed. Please try again.');
                    return;
                }

                Log::info('reCAPTCHA: Verification passed');

            } else {
                Log::error('reCAPTCHA: API request failed', ['response' => $response->body()]);
                $fail('reCAPTCHA verification failed. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error('reCAPTCHA error: ' . $e->getMessage());
            $fail('reCAPTCHA verification failed. Please try again.');
        }
    }
}