<?php

namespace Morbzeno\PruebaDePlugin\Database\Factories;
// database/factories/BlogFactory.php

use Morbzeno\PruebaDePlugin\Models\Blogs;
use Morbzeno\PruebaDePlugin\Models\Tag;
use Morbzeno\PruebaDePlugin\Models\User;
use Morbzeno\PruebaDePlugin\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogsFactory extends Factory
{

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'image' => $this->faker->imageUrl(),
            'author' => User::factory(),
            'category_id' => Category::factory(), // si tienes categoría relacionada
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Blogs $blog) {
            $tags = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id');

            // Si no hay tags en la DB aún, créalos con factory
            if ($tags->isEmpty()) {
                $tags = Tag::factory()->count(3)->create()->pluck('id');
            }

            $blog->tags()->sync($tags);
        });
    }
};
