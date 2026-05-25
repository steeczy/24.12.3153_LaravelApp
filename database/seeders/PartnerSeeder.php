<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 5; $i++) {
            Partner::create([
                'name' => $faker->company,
                'logo_url' => $faker->randomElement([
                    'https://placehold.co/200x200',
                    'https://placehold.co/180x180',
                    'https://placehold.co/220x220',
                    'https://placehold.co/240x240',
                ]),
            ]);
        }
    }
}
