<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelRequest;
use App\Mail\PersonnelCreated;
use App\Models\Personnel;
use App\Models\Pressing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PersonnelController extends Controller
{
    public function index(Request $request)
    {
        //logic pour lister les personnels de chaque pressing à l'admin
        $personnels = Personnel::all();
        $pressingId = $request->get('pressing_id');
        $pressings = Pressing::all();

        if ($pressingId) {
            $personnels = Personnel::where('pressing_id', $pressingId)->get();
        } else {
            $personnels = Personnel::all();
        }

        return view('personnels.index', compact('personnels', 'pressingId', 'pressings'));
    }

    public function create()
    {
        $pressings = Pressing::All();
        return view('personnels.create', compact('pressings'));
    }


    public function store(PersonnelRequest $request)
    {
        try {
            DB::beginTransaction();

            // Gestion de l'image de profil
            $profilImage = null;
            if ($request->hasFile('profilImage')) {
                $imageName = time() . '_' . $request->file('profilImage')->getClientOriginalName();
                $profilImage = $request->file('profilImage')->storeAs('profil_images', $imageName, 'public');
            }

            // Création de l'utilisateur
            $user = User::create([
                'profilImage' => $profilImage,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'birthday' => $request->birthday,
                'contact' => $request->contact,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'adresse' => $request->adresse,
            ]);

            // Création du personnel
            $personnel = Personnel::create([
                'poste' => $request->poste,
                'date_embauche' => Carbon::now(),
                'personnel_id' => $user->id,
                'pressing_id' => $request->pressing_id
            ]);

            // Attribution du rôle
            $user->assignRole('personnel');

            // Envoi de l'email avec les identifiants
            try {
                Mail::to($user->email)->send(new PersonnelCreated($user, $request->password));
            } catch (\Exception $e) {
                Log::error('Erreur envoi email personnel: ' . $e->getMessage());
                // On continue malgré l'erreur d'envoi d'email
            }

            DB::commit();
            return redirect()
                ->route('personnels.index')
                ->with('success', 'Personnel créé avec succès. Un email a été envoyé avec les identifiants.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création personnel: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => 'Erreur lors de la création du personnel: ' . $e->getMessage()]);
        }
    }

    //founction de suppression d'un compte personnel
    public function destroy(Personnel $personnel)
    {
        //logic pour supprimer un personnel
        $personnel->user->delete();
        return redirect()->back()->with('success', 'Personnel supprimé avec succès.');
    }
}
