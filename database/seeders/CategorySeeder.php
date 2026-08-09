<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Land',       'slug' => 'land',       'icon' => 'bi-map'],
            ['name' => 'Flat',       'slug' => 'flat',       'icon' => 'bi-building'],
            ['name' => 'House',      'slug' => 'house',      'icon' => 'bi-house-door'],
            ['name' => 'Commercial', 'slug' => 'commercial', 'icon' => 'bi-shop'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
