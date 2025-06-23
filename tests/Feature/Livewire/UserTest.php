<?php

namespace Tests\Feature\Livewire;

use Morbzeno\PruebaDePlugin\Models\User;
use Morbzeno\PruebaDePlugin\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Morbzeno\PruebaDePlugin\Filament\Resources\UserResource\Pages\CreateUser;
use Morbzeno\PruebaDePlugin\Filament\Resources\UserResource\Pages\EditUser;
use Morbzeno\PruebaDePlugin\Filament\Resources\UserResource\Pages\ListUsers;
use function Pest\Livewire\livewire;

class UserTest extends TestCase
{
    

    public function test_users_table_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    

        Livewire::test(ListUsers::class)
            ->assertStatus(200)
            ->assertSee('Usuarios'); 
    }

    public function test_users_create_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    

        Livewire::test(CreateUser::class)
            ->assertStatus(200)
            ->assertSee('Usuarios'); 
    }

    public function test_users_edit_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin'); 
        $this->actingAs($user);
    
        $userToEdit = User::factory()->create();

        Livewire::test(EditUser::class, ['record' => $userToEdit->getKey()])
            ->assertStatus(200)
            ->assertSee('Usuarios');
    }

    public function test_users_table_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer'); 
        $this->actingAs($user);
    
        $response = $this->get(ListUsers::getUrl());
    
        $response->assertStatus(403);
    }
    
    
    public function test_users_create_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);
    
        $response = $this->get(CreateUser::getUrl());
    
        $response->assertStatus(403);
    }
    
    public function test_users_edit_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);
    
        $userToEdit = User::factory()->create();
    
        $response = $this->get(EditUser::getUrl(['record' => $userToEdit->getKey()]));
    
        $response->assertStatus(403);
    }

    public function test_user_can_be_created()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);
        $role = Roles::firstOrCreate(['name' => 'admin']);
        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'buenas tarde',
                'email' => 'prueba@gmail.com',
                'password' => 'Password123?',
                'roles' => [$role->id],
            ])
            ->call('create')
            ->assertHasNoErrors();

            $this->assertDatabaseHas('users', [
                'name' => 'buenas tarde',
                'email' => 'prueba@gmail.com',
            ]);
    }
    public function test_user_can_be_edited()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin);
        $role = Roles::firstOrCreate(['name' => 'admin']);
        $user = User::factory()->create([
            'name' => 'buenas tarde',
            'email' => 'prueba2@gmail.com',
            'password' => 'Password123?',
        ]);
        $user->assignRole('viewer');

        Livewire::test(EditUser::class, ['record' => $user->getKey()])
            ->fillForm([
                'name' => 'Nuevo Nombre',
            ])
            ->call('save')
            ->assertHasNoErrors();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nuevo Nombre',
        ]);
        
    }
    public function test_user_can_be_deleted()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);
        $role = Roles::firstOrCreate(['name' => 'admin']);
         Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'buenas tarde',
                'email' => 'prueba@gmail.com',
                'password' => 'Password123?',
                'roles' => [$role->id],
            ])
            ->call('create')
            ->assertHasNoErrors();

            $user = User::where('email','prueba@gmail.com')->first();
            $user->delete();

            $this->assertDatabaseMissing('users', [
                'name' => 'buenas tarde',
                'email' => 'prueba@gmail.com',
            ]);
    }
use RefreshDatabase;
}
