<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class TechnologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $technologies = ['PHP', 'Vue', 'Laravel', 'Bootstrap'];

        foreach ($technologies as $technology) {
            $newTecnology = new Technology();
            $newTecnology->name = $technology;
            $newTecnology->slug = Str::slug($newTecnology->name);
            $newTecnology->hex_color = $faker->hexColor();

            $newTecnology->save();
        }
    }
}
