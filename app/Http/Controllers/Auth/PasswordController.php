<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $password = $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        if($password){
            return back()->with('success', 'Mot de passe modifier correctement');
        }else{
            return back()->with('error', 'Echec de modification du mot de passe!');
        }
        
    }
}
