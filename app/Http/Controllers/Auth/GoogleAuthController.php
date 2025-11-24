<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google for authentication
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callback(): RedirectResponse
    {
        try {
            // Create Guzzle client with SSL verification disabled for local development
            $guzzleClient = new Client([
                'verify' => false,
                'timeout' => 30,
            ]);

            // Get Google user with custom Guzzle client
            $googleUser = Socialite::driver('google')
                ->setHttpClient($guzzleClient)
                ->stateless()
                ->user();

            return $this->handleGoogleUser($googleUser);
        } catch (Exception $e) {
            Log::error('Google OAuth Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('login')
                ->with('error', 'Unable to login with Google. Please try again.');
        }
    }

    /**
     * Handle the Google user data
     */
    private function handleGoogleUser($googleUser): RedirectResponse
    {
        $email = $googleUser->getEmail();
        $googleId = $googleUser->getId();
        $name = $googleUser->getName();
        $avatar = $googleUser->getAvatar();

        DB::beginTransaction();

        try {
            // SCENARIO 1: Check if user exists with this Google ID
            $userByGoogleId = User::where('google_id', $googleId)->first();

            if ($userByGoogleId) {
                // User already linked with Google - just login
                Auth::login($userByGoogleId, true);
                DB::commit();

                return redirect()->route('dashboard')
                    ->with('status', 'Welcome back, ' . $userByGoogleId->name . '!');
            }

            // SCENARIO 2: Check if user exists with this email (manual registration)
            $userByEmail = User::where('email', $email)->first();

            if ($userByEmail) {
                // User exists with email but not linked to Google
                // Link Google account to existing user
                $userByEmail->update([
                    'google_id' => $googleId,
                    'avatar' => $avatar ?? $userByEmail->avatar,
                    'auth_provider' => $userByEmail->auth_provider === 'local' ? 'both' : $userByEmail->auth_provider,
                    'email_verified_at' => $userByEmail->email_verified_at ?? now(),
                ]);

                Auth::login($userByEmail, true);
                DB::commit();

                return redirect()->route('dashboard')
                    ->with('status', 'Your Google account has been linked successfully! Welcome back, ' . $userByEmail->name . '!');
            }

            // SCENARIO 3: New user - create account
            $newUser = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random(32)),
                'google_id' => $googleId,
                'avatar' => $avatar,
                'auth_provider' => 'google',
                'email_verified_at' => now(),
            ]);

            // Assign default role
            $newUser->assignRole('user');

            Auth::login($newUser, true);
            DB::commit();

            return redirect()->route('dashboard')
                ->with('status', 'Welcome! Your account has been created successfully with Google.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Google OAuth User Handling Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
