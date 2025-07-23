<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        //Création de toutes les permissions
        $modules = ['commande', 'vetement', 'pressing', 'user'];
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::updateOrCreate(
                    ['name' => "{$action}-{$module}"],
                    ['guard_name' => 'web']
                );
            }
        }

        //Récupération des rôles
        $personnel = Role::findByName('personnel');
        $gestionnaire = Role::findByName('gestionnaire');
        // $client n’a pas besoin de permissions pour l’instant

        //Définition des permissions par rôle
        $rolePermissions = [
            'personnel' => [
                'view-commande', 'create-commande', 'edit-commande', 'delete-commande',
                'view-vetement', 'create-vetement', 'edit-vetement', 'delete-vetement',
            ],
            'gestionnaire' => [
                'view-commande', 'create-commande', 'edit-commande', 'delete-commande',
                'view-vetement', 'create-vetement', 'edit-vetement', 'delete-vetement',
                'view-pressing', 'create-pressing', 'edit-pressing', 'delete-pressing',
                'view-user', 'create-user', 'edit-user', 'delete-user',
            ],
        ];

        //Attribution des permissions
        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::findByName($roleName);
            $role->syncPermissions($permissions);
        }
    }
}