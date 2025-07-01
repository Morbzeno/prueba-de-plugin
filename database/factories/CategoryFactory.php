<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Morbzeno\PruebaDePlugin\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->word(),
            'slug' => $this->faker->word(),
        ];
    }
}
