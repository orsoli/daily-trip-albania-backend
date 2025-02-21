<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Adventure',
                'slug'        => 'adventure-tours',
                'description' => 'Experience thrilling adventures with activities like hiking, rock climbing, and zip-lining.',
            ],
            [
                'name'        => 'Cultural',
                'slug'        => 'cultural-tours',
                'description' => 'Discover rich cultural heritage through visits to museums, historical sites, and local traditions.',
            ],
            [
                'name'        => 'City',
                'slug'        => 'city-tours',
                'description' => 'Explore vibrant urban centers, architectural landmarks, and dynamic cityscapes.',
            ],
            [
                'name'        => 'Nature',
                'slug'        => 'nature-tours',
                'description' => 'Embrace the beauty of nature with scenic hikes, wildlife spotting, and peaceful retreats.',
            ],
            [
                'name'        => 'Mountain',
                'slug'        => 'mountain-tours',
                'description' => 'Experience breathtaking mountain views with activities such as hiking, skiing, and mountain biking.',
            ],
            [
                'name'        => 'Beach',
                'slug'        => 'beach-tours',
                'description' => 'Enjoy sunny beaches with water sports, snorkeling, and relaxing seaside escapes.',
            ],
            [
                'name'        => 'Historical',
                'slug'        => 'historical-tours',
                'description' => 'Step back in time with guided tours of ancient ruins, historical landmarks, and fascinating museums.',
            ],
        ];

        foreach ($categories as $category) {

            Category::create($category);

        }
    }
}
