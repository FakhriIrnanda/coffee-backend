<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Coffee', 'slug' => 'coffee', 'description' => 'Minuman Dengan bahan kopi', 'image' => null, 'is_active' => true],
            ['id' => 2, 'name' => 'Non-Coffee', 'slug' => 'non-coffee', 'description' => 'Minuman tidak ada bahan kopi', 'image' => null, 'is_active' => true],
            ['id' => 5, 'name' => 'Tea', 'slug' => 'tea', 'description' => 'Minuman Dengan bahan Teh', 'image' => null, 'is_active' => true],
        ];

        foreach ($categories as $data) {
            Category::firstOrNew(['slug' => $data['slug']])->forceFill($data)->save();
        }
    }
}
