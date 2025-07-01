<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Morbzeno\PruebaDePlugin\Models\Tag;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->word(),
            'slug' => $this->faker->word(),
        ];
    }
}
