<?php

namespace Tests\Feature\Livewire;

use Morbzeno\PruebaDePlugin\Models\User;
use Morbzeno\PruebaDePlugin\Models\Blogs;
use Morbzeno\PruebaDePlugin\Models\Category;
use Morbzeno\PruebaDePlugin\Models\Tag;
use Morbzeno\PruebaDePlugin\Models\Roles;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource\Pages\CreateBlogs;
use Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource\Pages\EditBlogs;
use Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource\Pages\ListBlogs;
use function Pest\Livewire\livewire;

class BlogTest extends TestCase
{
    

    public function test_blog_table_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    

        Livewire::test(ListBlogs::class)
            ->assertStatus(200)
            ->assertSee('Blogs'); 
    }

    public function test_blog_create_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    

        Livewire::test(CreateBlogs::class)
            ->assertStatus(200)
            ->assertSee('Blogs'); 
    }

    public function test_blog_edit_renders_for_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('super_admin'); 
        $this->actingAs($user);
    
        $blog = Blogs::factory()->create();

        Livewire::test(EditBlogs::class, ['record' => $blog->getKey()])
            ->assertStatus(200)
            ->assertSee('Blogs');
    }

    public function test_blogs_table_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer'); 
        $this->actingAs($user);
    
        $response = $this->get(ListBlogs::getUrl());
    
        $response->assertStatus(403);
    }
    
    
    public function test_blogs_create_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);
    
        $response = $this->get(CreateBlogs::getUrl());
    
        $response->assertStatus(403);
    }
    
    public function test_blogs_edit_renders_for_non_authorized_user()
    {
        $this->seed();
        $user = User::factory()->create();
        $user->assignRole('viewer');
        $this->actingAs($user);
    
        $userToEdit = Blogs::factory()->create();
    
        $response = $this->get(EditBlogs::getUrl(['record' => $userToEdit->getKey()]));
    
        $response->assertStatus(403);
    }

    public function test_blogs_can_be_created()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        $fakeImage = UploadedFile::fake()->image('blog.jpg');


        $category = Category::factory()->create();

        Livewire::test(CreateBlogs::class)
            ->fillForm([
                'title' => 'Blog de prueba',
                'description' => 'Descripcion de prueba',
                'image' => $fakeImage,
                'author' => $admin->id,
                'category_id' => $category->id, // ✅ Ahora es un ID
                'tags' => Tag::factory()->count(3)->create()->pluck('id')->toArray(), // ✅ Array de IDs
            ])
            ->call('create')
            ->assertHasNoErrors();

            $this->assertDatabaseHas('blogs', [
                'title' => 'Blog de prueba',
                'description' => 'Descripcion de prueba',
                'author' => $admin->id,
                'category_id' => $category->id,
            ]);
    }

    public function test_blogs_can_be_delete()
    {
        $this->seed();
        $admin = User::factory()->create();
        $admin->assignRole('super_admin');
        $this->actingAs($admin);

        $fakeImage = UploadedFile::fake()->image('blog.jpg');


        $category = Category::factory()->create();

        Livewire::test(CreateBlogs::class)
            ->fillForm([
                'title' => 'Blog de prueba',
                'description' => 'Descripcion de prueba',
                'image' => $fakeImage,
                'author' => $admin->id,
                'category_id' => $category->id, // ✅ Ahora es un ID
                'tags' => Tag::factory()->count(3)->create()->pluck('id')->toArray(), // ✅ Array de IDs
            ])
            ->call('create')
            ->assertHasNoErrors();

            $blog = Blogs::where('title', 'Blog de prueba')->first();
            $blog->delete();

            $this->assertDatabaseMissing('blogs', [
                'title' => 'Blog de prueba',
                'description' => 'Descripcion de prueba',
                'author' => $admin->id,
                'category_id' => $category->id,
            ]);
    }

    use RefreshDatabase;
}
