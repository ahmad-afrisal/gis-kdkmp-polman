<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            'Polewali',
            'Binuang',
            'Wonomulyo',
            'Campalagian',
            'Tapango',
            'Mapilli',
            'Luyo',
            'Anreapi',
            'Matakali',
            'Balanipa',
            'Tinambung',
            'Allu',
            'Bulo',
            'Limboro',
            'Matangnga',
            'Tutar',
        ];

        foreach ($districts as $name) {
            DB::table('districts')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'geojson' => null,
                'color' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
