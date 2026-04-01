<?php

namespace Database\Seeders;

use App\Models\BussinessAssistant;
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
            [
                'name' => 'MUH IDHAM',
                'slug' => Str::slug('MUH IDHAM'),
                'address' => 'Matakali',
                'phone_number' => '085219493472',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ALWI SYAM',
                'slug' => Str::slug('ALWI SYAM'),
                'address' => 'Wonomulyo',
                'phone_number' => '087806354020',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'ASTY ESHA NADIA',
                'slug' => Str::slug('ASTY ESHA NADIA'),
                'address' => 'Campalagian',
                'phone_number' => '082396040425',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'ANDI NOFRIAWAN',
                'slug' => Str::slug('ANDI NOFRIAWAN'),
                'address' => 'Polewali',
                'phone_number' => '081242837306',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'HASANA',
                'slug' => Str::slug('HASANA'),
                'address' => 'Limboro',
                'phone_number' => '082229769145',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'HERMAN MALIK',
                'slug' => Str::slug('HERMAN MALIK'),
                'address' => 'Luyo',
                'phone_number' => '082187657836',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],  
            [
                'name' => 'HERNIDA RAHMAN',
                'slug' => Str::slug('HERNIDA RAHMAN'),
                'address' => 'Tinambung',
                'phone_number' => '082290622685',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'HUSNAWATI',
                'slug' => Str::slug('HUSNAWATI'),
                'address' => 'Campalagian',
                'phone_number' => '082214112903',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'IRDAH',
                'slug' => Str::slug('IRDAH'),
                'address' => 'Anreapi',
                'phone_number' => '082211416485',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'MARDIANA H',
                'slug' => Str::slug('MARDIANA H'),
                'address' => 'Campalagian',
                'phone_number' => '082187357112',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'MUH ARASY',
                'slug' => Str::slug('MUH ARASY'),
                'address' => 'Binuang',
                'phone_number' => '082283193069',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'MA\'RUF S',
                'slug' => Str::slug('MA\'RUF S'),
                'address' => 'Mapilli',
                'phone_number' => '0813437996900',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'NADHILAH',
                'slug' => Str::slug('NADHILAH'),
                'address' => 'Polewali',
                'phone_number' => '082196526608',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'RUSTAM',
                'slug' => Str::slug('RUSTAM'),
                'address' => 'Campalagian',
                'phone_number' => '081345208836',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'NURUL ULYA',
                'slug' => Str::slug('NURUL ULYA'),
                'address' => 'Binuang',
                'phone_number' => '085330833063',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'RAHMADANI',
                'slug' => Str::slug('RAHMADANI'),
                'address' => 'Campalagian',
                'phone_number' => '081374247724',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'REZKY AMALIA SARI S. HUT',
                'slug' => Str::slug('REZKY AMALIA SARI S. HUT'),
                'address' => 'Polewali',
                'phone_number' => '082343466633',
                'date_of_birth' => '1990-01-01',
                'picture' => 'path/to/picture.jpg',
                'is_active' => true,
            ],

        ];

        foreach ($BussinessAssistants as $assistant) {
            // DB::table('bussiness_assistants')->insert($assistant);
          
            $assistant = BussinessAssistant::create($assistant);
            // $assistant->assignRole('bussiness-assistant');
        }
    }
}
