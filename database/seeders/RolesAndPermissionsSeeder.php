<?php

// namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;

// class RolesAndPermissionsSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
        
        
//         //création des rôles
//         Role::create(
//             ['name' => 'client']
            
//          );
//         Role::create([
//             'name' => 'personnel'
//         ]);
//         Role::create([
//             'name' => 'gestionnaire'
//         ]);



//         //Permissions pour les commandes
//         Permission::create(['name' => 'view-commande']);
//         Permission::create(['name' => 'create-commande']);
//         Permission::create(['name' => 'edit-commande']);
//         Permission::create(['name' => 'delete-commande']);

//         //Permissions pour les vêtements
//         Permission::create(['name' => 'view-vetement']);
//         Permission::create(['name' => 'create-vetement']);
//         Permission::create(['name' => 'edit-vetement']);
//         Permission::create(['name' => 'delete-vetement']);


//         //Permissions pour les pressings
//         Permission::create(['name' => 'view-pressing']);
//         Permission::create(['name' => 'create-pressing']);
//         Permission::create(['name' => 'edit-pressing']);
//         Permission::create(['name' => 'delete-pressing']);


//         //Récupère ou crée les rôles
//         $client = Role::where('name', 'client')->first() ?? Role::create(['name' => 'client']);        
//         $personnel = Role::where('name', 'personnel')->first() ?? Role::create(['name' => 'personnel']);
//         $gestionnaire = Role::where('name', 'gestionnaire')->first() ?? Role::create(['name' => 'gestionnaire']);



//         //Commandes
//         $viewCommande = Permission::where('name', 'view-commande')->first() ?? Permission::create(['name' => 'view-commande']);
//         $createCommande = Permission::where('name', 'create-commande')->first() ?? Permission::create(['name' => 'create-commande']);
//         $editCommande = Permission::where('name', 'edit-commande')->first() ?? Permission::create(['name' => 'edit-commande']);
//         $deleteCommande = Permission::where('name', 'delete-commande')->first() ?? Permission::create(['name' => 'delete-commande']);

//         //Vêtements
//         $viewVetement = Permission::where('name', 'view-vetement')->first() ?? Permission::create(['name' => 'view-vetement']);
//         $createVetement = Permission::where('name', 'create-vetement')->first() ?? Permission::create(['name' => 'create-vetement']);
//         $editVetement = Permission::where('name', 'edit-vetement')->first() ?? Permission::create(['name' => 'edit-vetement']);
//         $deleteVetement = Permission::where('name', 'delete-vetement')->first() ?? Permission::create(['name' => 'delete-vetement']);



//         //Users
//         $viewUser = Permission::where('name', 'view-user')->first() ?? Permission::create(['name' => 'view-user']);
//         $createUser = Permission::where('name', 'create-user')->first() ?? Permission::create(['name' => 'create-user']);
//         $editUser = Permission::where('name', 'edit-user')->first() ?? Permission::create(['name' => 'edit-user']);
//         $deleteUser = Permission::where('name', 'delete-user')->first() ?? Permission::create(['name' => 'delete-user']);

//         //Pressings
//         $viewPressing = Permission::where('name', 'view-pressing')->first() ?? Permission::create(['name' => 'view-pressing']);
//         $createPressing = Permission::where('name', 'create-pressing')->first() ?? Permission::create(['name' => 'create-pressing']);
//         $editPressing = Permission::where('name', 'edit-pressing')->first() ?? Permission::create(['name' => 'edit-pressing']);
//         $deletePressing = Permission::where('name', 'delete-pressing')->first() ?? Permission::create(['name' => 'delete-pressing']);


//         //Assigner les permissions aux rôles

//         //Personnel : commandes + vêtements
//         $personnel->givePermissionTo([
//             $viewCommande, $createCommande, $editCommande,$deleteCommande,
//             $viewVetement, $createVetement, $editVetement,$deleteVetement
//         ]);


//         //Gestionnaire : commandes, vêtements, pressings
//         $gestionnaire->givePermissionTo([
//             $viewCommande, $createCommande, $editCommande,$deleteCommande,
//             $viewVetement, $createVetement, $editVetement,$deleteVetement,
//             $viewPressing, $createPressing, $editPressing,$deletePressing,
//             $viewUser,$createUser,$editUser,$deleteUser 
//         ]);

//     }
// }



// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;

// class RolesAndPermissionsSeeder extends Seeder
// {
//     public function run(): void
//     {
//         // Réinitialise le cache au début
//         app()['cache']->forget('spatie.permission.cache');

//         // Création ou récupération SÛRE des rôles avec guard_name
//         $client = Role::firstOrCreate(['name' => 'client'], ['guard_name' => 'web']);
//         $personnel = Role::firstOrCreate(['name' => 'personnel'], ['guard_name' => 'web']);
//         $gestionnaire = Role::firstOrCreate(['name' => 'gestionnaire'], ['guard_name' => 'web']);

//         // Liste des permissions
//         $permissions = [
//             'view-commande', 'create-commande', 'edit-commande', 'delete-commande',
//             'view-vetement', 'create-vetement', 'edit-vetement', 'delete-vetement',
//             'view-user', 'create-user', 'edit-user', 'delete-user',
//             'view-pressing', 'create-pressing', 'edit-pressing', 'delete-pressing',
//         ];

//         // Créer chaque permission avec guard_name
//         foreach ($permissions as $name) {
//             Permission::firstOrCreate(['name' => $name], ['guard_name' => 'web']);
//         }

//         // Assigner les permissions
//         $personnel->syncPermissions([
//             'view-commande', 'create-commande', 'edit-commande', 'delete-commande',
//             'view-vetement', 'create-vetement', 'edit-vetement', 'delete-vetement',
//         ]);

//         $gestionnaire->syncPermissions([
//             'view-commande', 'create-commande', 'edit-commande', 'delete-commande',
//             'view-vetement', 'create-vetement', 'edit-vetement', 'delete-vetement',
//             'view-pressing', 'create-pressing', 'edit-pressing', 'delete-pressing',
//             'view-user', 'create-user', 'edit-user', 'delete-user',
//         ]);
//     }
// }