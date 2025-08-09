<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PersonnelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date|before:-20 years',
            'contact' => 'required|string|max:15|unique:users,contact',

            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required','confirmed',
                Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised(),
            ],
            'adresse' => 'required|string|max:255',
            'profilImage' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'poste' => 'required|string|max:255',

            'pressing_id' => ['required','exists:pressings,pressing_id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de famille est obligatoire.',
            'last_name.required' => 'Le prénom est obligatoire.',
            'birthday.before' => 'La personne doit avoir au moins 20 ans.',
            'contact.regex' => 'Le numéro de téléphone semble invalide.',
            'email.unique' => 'Un utilisateur avec cet email existe déjà.',
            'contact.unique' => 'Un utilisateur avec ce numéro existe déjà.',
            'password.min' => 'Le mot de passe doit faire au moins 8 caractères.',
            'password.mixedCase' => 'Le mot de passe doit contenir des majuscules et minuscules.',
            'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.symbols' => 'Le mot de passe doit contenir au moins un symbole.',
            'profilImage.dimensions' => 'L\'image ne doit pas dépasser 2000x2000 pixels.',
        ];
    }
}
