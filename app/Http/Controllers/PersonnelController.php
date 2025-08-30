<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelRequest;
use App\Mail\PersonnelCreated;
use App\Models\Personnel;
use App\Models\Pressing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

    #vue de la gestion des comptes
    public function compte()
    {
        $user = Auth::user();
        $personnels = Personnel::with(['user', 'pressing'])
            ->when($user->hasRole('gestionnaire'), function ($query) {
                return $query->whereHas('pressing');
            })
            ->when($user->hasRole('personnel'), function ($query) use ($user) {
                return $query->where('pressing_id', $user->personnel->pressing_id);
            })
            ->get();

        // Récupérer tous les rôles et permissions
        $roles = Role::all();
        $permissions = Permission::all();

        return view('personnels.acompte', compact('personnels', 'roles', 'permissions'));
    }

    public function updateAccount(Request $request, Personnel $personnel)
    {
        $request->validate([
            'poste' => 'required|string',
            'status' => 'required|in:actif,inactif'
        ]);

        $personnel->update([
            'poste' => $request->poste,
            'status' => $request->status
        ]);

        return back()->with('success', 'Compte mis à jour avec succès');
    }

    public function updateRoles(Request $request, Personnel $personnel)
    {
        $request->validate([
            'roles' => 'array',
            'permissions' => 'array'
        ]);

        $user = $personnel->user;

        // Synchroniser les rôles
        $user->syncRoles($request->roles ?? []);

        // Synchroniser les permissions directes
        $user->syncPermissions($request->permissions ?? []);

        return back()->with('success', 'Rôles et permissions mis à jour avec succès');
    }
    //founction de suppression d'un compte personnel
    public function destroy(Personnel $personnel)
    {
        //logic pour supprimer un personnel
        //suppression du de l'image profile
        if ($personnel->user->profilImage) {
            Storage::disk('public')->delete($personnel->user->profilImage);
        }
        $personnel->user->delete();
        return redirect()->back()->with('success', 'Personnel supprimé avec succès.');
    }
}
