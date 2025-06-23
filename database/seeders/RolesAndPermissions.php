<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Morbzeno\PruebaDePlugin\Models\User;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $models = ['permiso', 'rol', 'usuario', 'etiqueta', 'categoría', 'publicacion'];
        $actions = [
            'ver_cualquier',
            'ver',
            'crear',
            'actualizar',
            'eliminar',
            'eliminar_cualquier',
        ];
        
        foreach ($models as $model) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action}_{$model}",
                    'guard_name' => 'web',
                ]);
            }
        }


        $superAdmin = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);
        
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        
        $viewer = Role::firstOrCreate([
            'name' => 'viewer',
            'guard_name' => 'web'
        ]);

        $suscriptor = Role::firstOrCreate([
            'name' => 'suscriptor',
            'guard_name' => 'web'
        ]);

        $seguidor = Role::firstOrCreate([
            'name' => 'seguidor',
            'guard_name' => 'web'
        ]);

        $colaborador = Role::firstOrCreate([
            'name' => 'colaborador',
            'guard_name' => 'web'
        ]);
    
        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions(Permission::whereIn('name', [
            'ver_cualquier_usuario', 'ver_usuario', 'actualizar_usuario', 'crear_usuario'
        ])->get());

        $viewer->syncPermissions(Permission::whereIn('name', [
            'ver_cualquier_rol'
        ])->get());

        $suscriptor->syncPermissions(Permission::whereIn('name', [
            'ver_cualquier_usuario, ver_usuario'
        ])->get());

        $seguidor->syncPermissions(Permission::whereIn('name', [
            'ver_cualquier_usuario'
        ])->get());

        $colaborador->syncPermissions(Permission::whereIn('name', [
            'ver_cualquier_rol', 'ver_rol', 'ver_autor', 'ver_cualquier_autor'
        ])->get());

        $superad = User::create(
            ['email' => 'superAdmin@gmail.com' ,
                'name' => 'Super admin',
                'password' => Hash::make('Password123?'),
                'email_verified_at' => now(),
            ]
        );

        $superad->assignRole('super_admin');

        $admins = User::create(
            ['email' => 'admin@gmail.com' ,
                'name' => 'Admin',
                'password' => Hash::make('Password123?'),
                'email_verified_at' => now(),
            ]
        );

        $admins->assignRole('admin');

        $viewers = User::create(
            ['email' => 'viewer@gmail.com' ,
                'name' => 'viewer',
                'password' => Hash::make('Password123?'),
                'email_verified_at' => now(),
            ]
        );

        $viewers->assignRole('viewer');

        $suscriptors = User::create(
            ['email' => 'suscriptor@gmail.com' ,
                'name' => 'suscriptor',
                'password' => Hash::make('Password123?'),
                'email_verified_at' => now(),
            ]
        );

        $suscriptors->assignRole('suscriptor');

        $seguidors = User::create(
            ['email' => 'seguidor@gmail.com' ,
                'name' => 'seguidor',
                'password' => Hash::make('Password123?'),
                'email_verified_at' => now(),
            ]
        );

        $seguidors->assignRole('seguidor');

        $seguidors = User::create(
            ['email' => 'colaborador@gmail.com' ,
                'name' => 'colaborador',
                'password' => Hash::make('Password123?'),
                'email_verified_at' => now(),
            ]
        );

        $seguidors->assignRole('colaborador');
        

    }
}
