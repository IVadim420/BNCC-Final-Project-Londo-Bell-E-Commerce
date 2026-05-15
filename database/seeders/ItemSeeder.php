<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = ItemCategory::create([
            'category' => 'Elektronik'
        ]);

        Item::factory(50)->create([
            'category_id' => $category->id
        ]);
    }
}
