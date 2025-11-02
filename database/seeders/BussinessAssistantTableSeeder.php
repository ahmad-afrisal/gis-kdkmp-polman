<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BussinessAssistantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $BussinessAssistants = [
            'ADAM',
            'ALWI SYAM',
            'ASTY ESHA NADIA',
            'DUHAL ADAM',
            'HASANA',
            'HENDRA WAHID',
            'HERNIDA RAHMAN',
            'HUSNAWATI',
            'IRDAH',
            'MARDIANA H',
            'MUHAMMAD ASLAM',
            'MUHAMMAD YUSUF',
            'MUH ARASY',
            'NURUL PRATIWI',
            'NURUL ULYA',
            'RAHMADANI',
            'REZKY AMALIA SARI S . HUT'
        ];

        foreach ($BussinessAssistants as $name) {
            DB::table('bussiness_assistants')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
