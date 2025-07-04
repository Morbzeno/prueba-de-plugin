<?php

namespace Morbzeno\PruebaDePlugin\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Morbzeno\PruebaDePlugin\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(50)
            ->create();
    }
}
