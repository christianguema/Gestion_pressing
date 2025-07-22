<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\Pressing;
use Faker\Provider\ar_EG\Person;
use Illuminate\Http\Request;

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



    //founction de suppression d'un compte personnel
    public function destroy(Personnel $personnel)
    {
        //logic pour supprimer un personnel
        $personnel->user->delete();
        return redirect()->back()->with('success', 'Personnel supprimé avec succès.');
    }
}
