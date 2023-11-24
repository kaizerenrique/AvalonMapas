<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Roles del Sistema
        $admin = Role::create(['name' => 'Administrador']); //Administrador del Sistema
        $user = Role::create(['name' => 'Usuario']); //Usuario Final


        //Permisos del Sistema
        //Permisos de la barra del menu
        Permission::create(['name' => 'menuUsuarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'menuConfiguracion'])->syncRoles([$admin]); 
        
        //usuario
        User::create([
            'name' => 'Oliver Gomez',
            'email' => 'kayserenrique@gmail.com',
            'password' => bcrypt('123456789'),
            'email_verified_at' => '2022-02-26 20:48:29'
        ])->assignRole('Administrador');

    }
}
