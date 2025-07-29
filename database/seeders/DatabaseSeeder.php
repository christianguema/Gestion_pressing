<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            PressingSeeder::class,
            CategorieSeeder::class,
            VetementSeeder::class,
            TypePrestationSeeder::class,
            TypeFacturationSeeder::class,
            RemiseSeeder::class,
            UserSeeder::class,
            //CategorieSeeder::class,

            // PressingSeeder::class,
            //CommandeSeeder::class,
            //CommandeVetementSeeder::class,

            // PaiementSeeder::class,
            // RapportPerformanceSeeder::class

        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',

        // ]);
    }
}
