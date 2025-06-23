<?php

namespace Database\Factories;


use Morbzeno\PruebaDePlugin\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->word(),
            'slug' => $this->faker->word(),
        ];
    }
};