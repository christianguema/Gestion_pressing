<?php

namespace App\Http\Controllers;

use App\Models\Remise;
use Database\Seeders\RemiseSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RemiseController extends Controller
{
    public function index()
    {
        $remises = Remise::all();
        return view('Remises.index',compact("remises"));
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
                $validate = $request->validate([
                    'valeur'=>'required|numeric|min:0',
                    'type_remise'=>'required|string|max:200',
                    'description'=>'required|string|max:250'
                ]);

                Remise::create([
                    'valeur'=>$validate['valeur'],
                    'type_remise'=>$validate['type_remise'],
                    'description'=>$validate['description']
                ]);

            DB::commit();
            return redirect()->back()->with('success', 'Remise enregistré avec succès');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','Remise non enregistré'.$e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();
                $remise = Remise::findOrfail($id);

                $validate = $request->validate([
                    'valeur'=>'required|numeric|min:0',
                    'type_remise'=>'required|string|max:200',
                    'description'=>'required|string|max:250'
                ]);

                $remise->update([
                    'valeur'=>$validate['valeur'],
                    'type_remise'=>$validate['type_remise'],
                    'description'=>$validate['description']
                ]);
            DB::commit();
            return redirect()->back()->with('success','Remise modifier avec succèss');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->witch('error',"Echec remise non modifier"." ".$e->getMessage());
        }

    }

    public function destroy($id)
    {
        try{
            $remise = Remise::findOrfail($id);

            $remise->delete();

            return redirect()->back()->with('success','Remise supprimé avec success');
        }catch(\Exception $e){
            return redirect()->back()->with('error', "remise non supprimer"." ".$e->getMessage());
        }

    }


}
