<?php

namespace Database\Factories;


use Morbzeno\PruebaDePlugin\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
};