<?php

namespace Tests\Feature\Livewire;

use Morbzeno\PruebaDePlugin\Models\User;
use Morbzeno\PruebaDePlugin\Models\Category;
use Morbzeno\PruebaDePlugin\Models\Roles;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Morbzeno\PruebaDePlugin\Filament\Resources\CategoryResource\Pages\CreateCategory;
use Morbzeno\PruebaDePlugin\Filament\Resources\CategoryResource\Pages\EditCategory;
use Morbzeno\PruebaDePlugin\Filament\Resources\CategoryResource\Pages\ListCategories;
use function Pest\Livewire\livewire;

class CategoryTest extends TestCase
{

    public function test_category_table_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    

        Livewire::test(ListCategories::class)
            ->assertStatus(200);
    }
    
    public function test_category_create_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    

        Livewire::test(CreateCategory::class)
            ->assertStatus(200);
    }

    public function test_category_edit_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin'); 
        $this->actingAs($user);
    
        $Category = Category::factory()->create();

        Livewire::test(EditCategory::class, ['record' => $Category->getKey()])
            ->assertStatus(200);
    }

    public function test_category_table_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);
    

        Livewire::test(ListCategories::class)
            ->assertStatus(403);
    }

    public function test_category_create_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);
    

        Livewire::test(CreateCategory::class)
            ->assertStatus(403);
    }

    public function test_category_edit_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer'); 
        $this->actingAs($user);
    
        $Category = Category::factory()->create();

        Livewire::test(EditCategory::class, ['record' => $Category->getKey()])
            ->assertStatus(403);
    }

    public function test_category_can_be_created()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        Livewire::test(CreateCategory::class)
            ->fillForm([
                'name' => 'tag de prueba',
                'description' => 'Descripcion de prueba',
            
            ])
            ->call('create')
            ->assertHasNoErrors();

            $this->assertDatabaseHas('categories', [
                'name' => 'tag de prueba',
                'description' => 'Descripcion de prueba',
            ]);
    }

    public function test_category_can_be_edited()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        $tag = Category::factory()->create([
            'name' => 'tag de prueba',
            'description' => 'Descripcion de prueba',
        ]);
            Livewire::test(EditCategory::class, ['record' => $tag->getKey()])
            ->fillForm([
            'name' => 'nombre nuevo',
            ])
            ->call('save')
            ->assertHasNoErrors();


            $this->assertDatabaseHas('categories', [
                'name' => 'nombre nuevo',
                'description' => 'Descripcion de prueba',
            ]);
    }

    public function test_category_can_be_delete()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        Livewire::test(CreateCategory::class)
            ->fillForm([
                'name' => 'tag de prueba',
                'description' => 'Descripcion de prueba',
                'slug' => 'slug-de-prueba',
            
            ])
            ->call('create')
            ->assertHasNoErrors();

            $category = Category::where('name', 'tag de prueba')->first();

            $category->delete();

            $this->assertDatabaseMissing('categories', [
                'name' => 'tag de prueba',
                'description' => 'Descripcion de prueba',
                'slug' => 'slug-de-prueba',
            ]);
    }

    use RefreshDatabase;
}
