<?php

namespace Database\Seeders;

use Morbzeno\PruebaDePlugin\Models\Blogs;
use Morbzeno\PruebaDePlugin\Models\Tag;
use Morbzeno\PruebaDePlugin\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run(): void
    {

        $faker = \Faker\Factory::create();
                for ($i = 0; $i < 50; $i++) {
                    $name = implode(' ', $faker->words(2));
                    DB::table('tags')->insert([
                        'name' => $name,
                        'description' => $faker->sentence,
                        'slug' => \Str::slug($name) . '-' . $i,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

        $faker = \Faker\Factory::create();
            for ($i = 0; $i < 50; $i++) {
                $name = implode(' ', $faker->words(2));
                DB::table('categories')->insert([
                    'name' => $name,
                    'description' => $faker->sentence,
                    'slug' => \Str::slug($name) . '-' . $i,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            for ($i = 0; $i < 50; $i++) {
                $name = implode(' ', $faker->words(2));
            
                $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
            
                $tags = Tag::inRandomOrder()->take(3)->pluck('id');
            
                $blog = Blogs::create([
                    'title' => $name,
                    'description' => $faker->paragraph(),
                    'image' => 'https://picsum.photos/id/'. $i .'/300/300',
                    'author' => 'viewer',
                    'category_id' => $category->id,
                    'slug' => \Str::slug($name . '-' . uniqid()),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            
                $blog->tags()->attach($tags);
            }
    }
}
