<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch all category IDs and user IDs
        $categoryIds = Category::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // Generate 50 fake events
        for ($i = 0; $i < 50; $i++) {
            Event::create([
                'title' => $faker->sentence(3), // Random title with 3 words
                'description' => $faker->paragraph, // Random description
                'image' => $faker->imageUrl(800, 600, 'events'), // Random image URL
                'start_date' => $faker->date('Y-m-d'), // Random start date
                'end_date' => $faker->date('Y-m-d'), // Random end date
                'org_name' => $faker->company, // Random organization name
                'org_email' => $faker->companyEmail, // Random organization email
                'org_phone' => $faker->phoneNumber, // Random phone number
                'org_logo' => $faker->imageUrl(200, 200, 'logos'), // Random logo URL
                'category_id' => $faker->randomElement($categoryIds), // Random category ID (assuming 1-10)
                'limit' => $faker->numberBetween(10, 100), // Random limit number
                'location' => $faker->address, // Random address
                'plaform' => $faker->randomElement(['Online', 'Offline', 'Hybrid']), // Random platform
                'created_by' => $faker->randomElement($userIds), // Random user ID (assuming 1-50)
                'created_at' => now(), // Use current timestamp
                'updated_at' => now(), // Use current timestamp
            ]);
        }
    }
}
