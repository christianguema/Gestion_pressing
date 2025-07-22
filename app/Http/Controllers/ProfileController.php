<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\profilRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function edit(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(profilRequest $request): RedirectResponse
    {

        dd($request->validated());

        $request->user()->fill($request->validated());
        //$request->validated();
        //dump($request->profileImage);

        $user = Auth::user();
        if ($user instanceof \App\Models\User) {
            if ($request->hasFile('profileImage')) {
                if ($user->profilImage) {
                    FacadesStorage::disk('Photo_profil')->delete($user->profilImage);
                }
                $imageName = $request->file('profileImage')->getClientOriginalName();
                $imagePath = $request->file('profileImage')->storeAs('Photo_profil', $imageName, 'public');
                $user->profileImage = $imagePath;
                $user->save();
            }
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }

    public function deleteImage()
    {
        $user = Auth::user();
        if ($user instanceof \App\Models\User) {
            if ($user->profilImage) {
                FacadesStorage::disk('Photo_profil')->delete($user->profilImage);
                $user->profileImage = null;
                $user->save();

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false], 400);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
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
