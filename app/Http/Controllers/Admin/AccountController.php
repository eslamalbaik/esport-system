<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Display the account settings page for the authenticated administrator.
     */
    public function edit(Request $request): View
    {
        return view('admin.account', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the admin's display name.
     */
    public function updateUsername(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updateUsername', [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = $request->user();
        $user->forceFill([
            'name' => $validated['name'],
        ])->save();

        return back()->with('status', __('Username updated successfully.'));
    }

    /**
     * Update the admin's login email.
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validateWithBag('updateEmail', [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'current_password' => ['required', 'current_password'],
        ]);

        if ($validated['email'] === $user->email) {
            return back()->with('status', __('Email address is unchanged.'));
        }

        $user->forceFill([
            'email' => strtolower($validated['email']),
        ])->save();

        return back()->with('status', __('Email updated successfully.'));
    }

    /**
     * Update the admin's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->forceFill([
            'password' => $validated['password'],
        ])->save();

        $request->session()->put('password_hash_web', $request->user()->getAuthPassword());
        $request->session()->regenerate();

        return back()->with('status', __('Password updated successfully.'));
    }
}
