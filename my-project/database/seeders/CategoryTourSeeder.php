<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id')->toArray();
        $tours = Tour::pluck('id')->toArray();

        if(empty($categories) || empty($tours)) return ;
        // Variables
        $data = [];
        $uniquePairs = [];

        for ($i = 0; $i < 20; $i++) {
            do {
                $categoryId = $categories[array_rand($categories)];
                $tourId = $tours[array_rand($tours)];
                $pair = "{$categoryId}_{$tourId}"; // Create a unique pair to identify
            } while (in_array($pair, $uniquePairs)); // Check if the combination is repeated

            $uniquePairs[] = $pair;
            $data[] = [
                'category_id' => $categoryId,
                'tour_id'     => $tourId,
            ];
        }

        DB::table('category_tour')->insert($data);
    }
}