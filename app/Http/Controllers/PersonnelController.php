<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelRequest;
use App\Models\Personnel;
use App\Models\Pressing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PersonnelController extends Controller
{
    public function create(){
        $pressings = Pressing::All();
        
        return view('personnels.create',compact('pressings'));
    }

     public function show($id)
    {
        abort(404);
    }

    public function store(PersonnelRequest $request){
        
         //dd("Formulaire soumis !", $request->all());
        DB::beginTransaction();
        try {
            //information générale sur tous les utilisateurs
        // dd($request);
Log::info('Début transaction');

            $user = User::create([
                'name' => $request['name'],
                'lastname' => $request['lastname'],
                'birthday' => $request['birthday'],
                'contact' =>$request['contact'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'adresse' =>$request['adresse'],

            ]);
            Log::info('Utilisateur créé : ' . $user->id);
    
            //ajout de la photo de profil du personnel 
            $personnel = Personnel::create([
                // 'profilImage' => $request['profilImage'],
                'profilImage' => $request->hasFile('profilImage') ? $request->file('profilImage')->store('profil_images', 'public'): null,
                'poste' => $request['poste'],
                'date_embauche' => Carbon::now() ,
                'user_id' => $user->id,
                'pressing_id' => $request['pressing_id']
            ]);
            Log::info('Personnel créé : ' . $personnel->personnel_id);
            // $personnel->assignRole('personnel');
            $user->syncRoles('personnel');

            Log::info('Rôle assigné');
 
            DB::commit();
            return redirect()->route('personnels.index')->with('success','Personnel créé avec succès');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Erreur création personnel : ' . $th->getMessage());
            // return back()->withErrors([
            //     'other' => 'Erreur',
            // ]);
            return back()->withErrors(['error' => 'Erreur : ' . $th->getMessage()])
             ->withInput();
        }
    }

    
    public function index()
    {
        // Charger les personnels avec leurs relations
        $personnels = Personnel::with(['user', 'pressing'])->get();

        return view('personnels.index', compact('personnels'));
    }

   public function edit($id)
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
        abort(404);
    }

    public function destroy($id)
    {
        abort(404);
    }

    //méthode pour voir le pressing du personnel connecté 
    // public function monPressing()
    // {
    //     $user = auth()->user();
    //     $personnel = $user->personnel; // suppose une relation 1:1 User → Personnel

    //     if (!$personnel) {
    //         abort(403, 'Accès refusé');
    //     }

    //     $pressing = $personnel->pressing;

    //     $pressing->loadCount([
    //         'personnels',
    //         'commandes',
    //         'rapportPerformances' // attention au nom de la relation
    //     ]);

    //     return view('pressings.show', compact('pressing'));
    // }
}
