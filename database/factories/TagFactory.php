<?php

namespace Database\Factories;


use Morbzeno\PruebaDePlugin\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

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
