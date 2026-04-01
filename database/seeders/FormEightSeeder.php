<?php

namespace Database\Seeders;

use App\Models\FormEight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormEightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormEight::factory()->count(167)->create();
    }
}
