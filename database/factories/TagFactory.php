<?php

namespace Database\Factories;


use Morbzeno\PruebaDePlugin\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
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