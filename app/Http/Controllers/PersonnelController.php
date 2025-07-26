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
        DB::beginTransaction();
        try {

            $user = User::create([
                'profilImage' => $request->hasFile('profilImage') ? $request->file('profilImage')->store('profil_images', 'public') : null,
                'name' => $request['name'],
                'last_name' => $request['last_name'],
                'birthday' => $request['birthday'],
                'contact' => $request['contact'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'adresse' => $request['adresse'],

            ]);
            //ajout de la photo de profil du personnel
            $personnel = Personnel::create([
                'poste' => $request['poste'],
                'date_embauche' => Carbon::now(),
                'personnel_id' => $user->id,
                'pressing_id' => $request['pressing_id']
            ]);
            $user->assignRole('personnel');

            //envoi d'email d'email
            DB::commit();
            return redirect()->route('personnels.index')->with('success', 'Personnel créé avec succès');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $th->getMessage()])
                ->withInput();
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
