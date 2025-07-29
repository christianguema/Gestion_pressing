<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypePrestationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime toutes les données existantes
        DB::table('type_prestations')->delete();

        // Définis les données à insérer
        $typePrestations = [
            ['intitule' => 'Nettoyage à sec','duree_moyenne'=>4,"cout_par_kilo"=>200],
            ['intitule' => 'Lavage à l\'eau','duree_moyenne'=>3,'cout_par_kilo'=>1000],
            ['intitule' => 'Repassage à la main','duree_moyenne'=>2,'cout_par_kilo'=>500],
            ['intitule' => 'Repassage à la machine','duree_moyenne'=>1,'cout_par_kilo'=>300],
            ['intitule' => 'Repassage','duree_moyenne'=>2,'cout_par_kilo'=>400],
            ['intitule' => 'Lavage et repassage','duree_moyenne'=>5,'cout_par_kilo'=>1500],
            ['intitule' => 'Nettoyage de tapis','duree_moyenne'=>6,'cout_par_kilo'=>2500],
            ['intitule' => 'Nettoyage de rideaux','duree_moyenne'=>4,'cout_par_kilo'=>1800],
            ['intitule' => 'Repassage de chemises','duree_moyenne'=>1,'cout_par_kilo'=>600],
            ['intitule' => 'Repassage express','duree_moyenne'=>1,'cout_par_kilo'=>700],
            ['intitule' => 'Lavage de vêtements délicats','duree_moyenne'=>3,'cout_par_kilo'=>1200],
            ['intitule' => 'Lavage de vêtements en laine','duree_moyenne'=>3,'cout_par_kilo'=>1300],
            ['intitule' => 'Lavage de vêtements en soie','duree_moyenne'=>3,'cout_par_kilo'=>1400],
            ['intitule' => 'Lavage de vêtements en coton','duree_moyenne'=>2,'cout_par_kilo'=>800],
            ['intitule' => 'Lavage express','duree_moyenne'=>1,'cout_par_kilo'=>900],
            ['intitule' => 'Lavage','duree_moyenne'=>3,'cout_par_kilo'=>1000],
            ['intitule' => 'Détachage','duree_moyenne'=>2,'cout_par_kilo'=>1100],
            ['intitule' => 'Teinture','duree_moyenne'=>3,'cout_par_kilo'=>1200],
        ];

        // Ajoute les timestamps automatiquement
        foreach ($typePrestations as &$prestation) {
            $prestation['created_at'] = now();
            $prestation['updated_at'] = now();
        }

        // Insère les données dans la table
        DB::table('type_prestations')->insert($typePrestations);
    }
}
