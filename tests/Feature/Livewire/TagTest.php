<?php

namespace Tests\Feature\Livewire;

use Morbzeno\PruebaDePlugin\Models\User;
use Morbzeno\PruebaDePlugin\Models\Tag;
use Morbzeno\PruebaDePlugin\Models\Roles;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource\Pages\CreateTags;
use Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource\Pages\EditTags;
use Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource\Pages\ListTags;
use function Pest\Livewire\livewire;

class TagTest extends TestCase
{

    public function test_tag_table_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    

        Livewire::test(ListTags::class)
            ->assertStatus(200);
    }
    
    public function test_tag_create_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    

        Livewire::test(CreateTags::class)
            ->assertStatus(200);
    }

    public function test_tag_edit_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin'); 
        $this->actingAs($user);
    
        $tag = Tag::factory()->create();

        Livewire::test(EditTags::class, ['record' => $tag->getKey()])
            ->assertStatus(200);
    }

    public function test_tag_table_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);
    

        Livewire::test(ListTags::class)
            ->assertStatus(403);
    }

    public function test_tag_create_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);
    

        Livewire::test(CreateTags::class)
            ->assertStatus(403);
    }

    public function test_tag_edit_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer'); 
        $this->actingAs($user);
    
        $tag = Tag::factory()->create();

        Livewire::test(EditTags::class, ['record' => $tag->getKey()])
            ->assertStatus(403);
    }

    public function test_tags_can_be_created()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        Livewire::test(CreateTags::class)
            ->fillForm([
                'name' => 'tag de prueba',
                'description' => 'Descripcion de prueba',
            
            ])
            ->call('create')
            ->assertHasNoErrors();

            $this->assertDatabaseHas('tags', [
                'name' => 'tag de prueba',
                'description' => 'Descripcion de prueba',
            ]);
    }

    public function test_tags_can_be_edited()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        $tag = Tag::factory()->create([
            'name' => 'tag de prueba',
            'description' => 'Descripcion de prueba',
        ]);
            Livewire::test(EditTags::class, ['record' => $tag->getKey()])
            ->fillForm([
            'name' => 'nombre nuevo',
            ])
            ->call('save')
            ->assertHasNoErrors();

            $this->assertDatabaseHas('tags', [
                'name' => 'nombre nuevo',
                'description' => 'Descripcion de prueba',
            ]);
    }

    public function test_tags_can_be_deleted()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        Livewire::test(CreateTags::class)
            ->fillForm([
                'name' => 'tag de prueba',
                'description' => 'Descripcion de prueba',
            ])
            ->call('create')
            ->assertHasNoErrors();

            $tag = Tag::where('name', 'tag de prueba')->first();

            $tag->delete();
            $this->assertDatabaseMissing('tags', [
                'name' => 'tag de prueba',
            ]);
    }


    use RefreshDatabase;
}
