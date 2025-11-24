<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use App\Rules\ValidEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'max:255', 'unique:'.User::class, new ValidEmail],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Store the plain password temporarily for the welcome email
        $plainPassword = $request->password;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign default 'user' role to new registrations
        $user->assignRole('user');

        // This will send the verification email
        event(new Registered($user));

        // Dispatch the welcome email job with credentials
        SendWelcomeEmail::dispatch($user, $plainPassword);

        // Don't log the user in automatically
        // Auth::login($user);

        // Redirect to login with registration success message
        return redirect()->route('login')
            ->with('registered', true)
            ->with('registered_email', $user->email);
    }
}