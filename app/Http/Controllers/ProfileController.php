<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\Intl\Countries;

class ProfileController extends Controller
{
    /**
     * Display the customer's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user('web');

        $user->load('profile');

        return view('store.profile.edit', [
            'user' => $user,
            'profile' => $user->profile,
            'countries' => Countries::getNames('en'),
        ]);
    }

    /**
     * Update the customer's profile information.
     */
    public function update(CustomerProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user('web');
        $validated = $request->validated();

        $user->fill(
            Arr::only($validated, [
                'name',
                'email',
            ])
        );

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $profile = $user->profile()->firstOrNew();

        $profile->fill(
            Arr::only($validated, [
                'first_name',
                'last_name',
                'phone_number',
                'birthday',
                'gender',
                'country',
                'city',
                'street_address',
                'postal_code',
            ])
        );

        $user->profile()->save($profile);

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the customer's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password:web'],
        ]);

        $user = $request->user('web');

        Auth::guard('web')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}