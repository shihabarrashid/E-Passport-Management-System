<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;


class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i = 0; $i < 5; $i++) 
        {
            $application = new Application;
            $application->user_id = 1;
            $application->name = $faker->name;
            $application->passport_type = 'Ordinary';
            $application->delivery_type = 'Regular';
            $application->save();
        }
    }
}

