<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Handle profile update.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // ✅ Validate form inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'address' => 'nullable|string|max:255',
            'phone' => ['nullable', 'regex:/^(98|97)\d{8}$/'],
            'gender' => 'nullable|in:male,female,other',
            'photo' => 'nullable|image|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // ✅ Handle photo upload
       if ($request->hasFile('photo')) {
    $photo = $request->file('photo');
    $filename = time() . '.' . $photo->getClientOriginalExtension();
    $photo->move(public_path('photos'), $filename);
    $user->photo = 'photos/' . $filename; // store relative path in DB
}


        // ✅ Update email (if changed)
        if ($validated['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        // ✅ Update other fields
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->address = $validated['address'] ?? null;
        $user->phone = $validated['phone'] ?? null;
        $user->gender = $validated['gender'] ?? null;

        // ✅ Update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Handle account deletion.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
