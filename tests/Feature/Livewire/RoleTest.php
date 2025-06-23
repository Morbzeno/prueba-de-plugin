<?php

namespace Tests\Feature\Livewire;

use Morbzeno\PruebaDePlugin\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\CreateRole;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\EditRole;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ListRoles;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ViewRole;
use function Pest\Livewire\livewire;

class RoleTest extends TestCase
{
      use RefreshDatabase;

    public function test_role_table_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);


        Livewire::test(ListRoles::class)
            ->assertStatus(200)
            ->assertSee('Roles');
    }

    public function test_role_create_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);


        Livewire::test(CreateRole::class)
            ->assertStatus(200)
            ->assertSee('Roles');
    }

    public function test_role_edit_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);

        $userToEdit = Role::create([
            'name' => 'editorson',
            'guard' => 'web',
        ]);
        Livewire::test(EditRole::class, ['record' => $userToEdit->getKey()])
            ->assertStatus(200)
            ->assertSee('Roles');
    }

    public function test_role_table_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);

        $response = $this->get(ListRoles::getUrl());

        $response->assertStatus(403);
    }


    public function test_role_create_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);

        $response = $this->get(CreateRole::getUrl());

        $response->assertStatus(403);
    }

    public function test_role_can_be_created()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);
        Livewire::test(CreateRole::class)
            ->fillForm([
                  'name' => 'editorson',
                  'guard_name' => 'web',
            ])
            ->call('create')
            ->assertHasNoErrors();

            $this->assertDatabaseHas('roles', [
                  'name' => 'editorson',
                  'guard_name' => 'web',
            ]);
    }
    public function test_role_can_be_edited()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        Livewire::test(CreateRole::class)
        ->fillForm([
              'name' => 'editorson',
              'guard_name' => 'web',
        ])
        ->call('create');
        $role = Role::where('name', 'editorson')->firstOrFail();

        Livewire::test(EditRole::class, ['record' => $role->getKey()])
            ->fillForm([
                'name' => 'Nuevo Nombre',
            ])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Nuevo Nombre',
        ]);

    }

    public function test_role_can_be_deleted()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);
        Livewire::test(CreateRole::class)
            ->fillForm([
                  'name' => 'editorson',
                  'guard_name' => 'web',
            ])
            ->call('create')
            ->assertHasNoErrors();
                $rol = Role::where('name', 'editorson')->first();
                $rol->delete();
            $this->assertDatabaseMissing('roles', [
                  'name' => 'editorson',
                  'guard_name' => 'web',
            ]);
    }

}
