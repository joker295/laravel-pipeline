<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Electronics',
            'Clothing',
            'Books',
            'Home & Kitchen',
            'Sports & Outdoors',
            'Beauty & Personal Care',
            'Toys & Games',
            'Automotive',
            'Health & Household',
            'Grocery',
            'Garden & Outdoors',
            'Jewelry',
            'Office Supplies',
            'Pet Supplies',
            'Music',
            'Movies',
            'Video Games',
            'Baby Products',
            'Tools & Home Improvement',
            'Art & Craft'
        ];

        foreach ($names as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
