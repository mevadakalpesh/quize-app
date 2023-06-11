<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CreateCategory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
          'php Developer',
          'Java Developer',
          'Wordpres Developer',
          'web designer',
        ];
        
        foreach ($categories as $category){
          Category::updateOrCreate(
            ['name' => $category],
            ['name' => $category],
          );
        }
    }
}
