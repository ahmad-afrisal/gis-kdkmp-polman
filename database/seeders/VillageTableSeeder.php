<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VillageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prefill = [

            // kecamatan Allu 
            ['name' => 'Petoosang',       'district_id' => 1, 'type' => 'Kelurahan'],
            ['name' => 'Alu',       'district_id' => 1, 'type' => 'Desa'],
            ['name' => 'Kalumammang',       'district_id' => 1, 'type' => 'Desa'],
            ['name' => 'Mombi',       'district_id' => 1, 'type' => 'Desa'],
            ['name' => 'Pao-pao',       'district_id' => 1, 'type' => 'Desa'],
            ['name' => 'Puppu uring',       'district_id' => 1, 'type' => 'Desa'],
            ['name' => 'Saragian',       'district_id' => 1, 'type' => 'Desa'],
            ['name' => 'Sayoang',       'district_id' => 1, 'type' => 'Desa'],

            // kecamatan Anreapi
            ['name' => 'Anreapi',       'district_id' => 2, 'type' => 'Kelurahan'],
            ['name' => 'Duampanua',       'district_id' => 2, 'type' => 'Desa'],
            ['name' => 'Kelapa Dua',       'district_id' => 2, 'type' => 'Desa'],
            ['name' => 'Kunyi',       'district_id' => 2, 'type' => 'Desa'],
            ['name' => 'Papandangan',       'district_id' => 2, 'type' => 'Desa'],

            // Kecamatan Binuang
            ['name' => 'Amassangan',       'district_id' => 3, 'type' => 'Kelurahan'],
            ['name' => 'Amola',       'district_id' => 3, 'type' => 'Desa'],
            ['name' => 'Batetangnga',       'district_id' => 3, 'type' => 'Desa'],
            ['name' => 'Kaleok',       'district_id' => 3, 'type' => 'Desa'],
            ['name' => 'Kuajang',       'district_id' => 3, 'type' => 'Desa'],
            ['name' => 'Mammi',       'district_id' => 3, 'type' => 'Desa'],
            ['name' => 'Mirring',       'district_id' => 3, 'type' => 'Desa'],
            ['name' => 'Paku',       'district_id' => 3, 'type' => 'Desa'],
            ['name' => 'Rea',       'district_id' => 3, 'type' => 'Desa'],
            ['name' => 'Tonyaman',       'district_id' => 3, 'type' => 'Desa'],

            // Kecamatan Balanipa
            ['name' => 'Balanipa',       'district_id' => 4, 'type' => 'Kelurahan'],
            ['name' => 'Bala',       'district_id' => 4, 'type' => 'Desa'],
            ['name' => 'Galung Tuluk',       'district_id' => 4, 'type' => 'Desa'],
            ['name' => 'Lambanan',       'district_id' => 4, 'type' => 'Desa'],
            ['name' => 'Lego',       'district_id' => 4, 'type' => 'Desa'],
            ['name' => 'Mosso',       'district_id' => 4, 'type' => 'Desa'],
            ['name' => 'Pallis',       'district_id' => 4, 'type' => 'Desa'],
            ['name' => 'Pambusuang',       'district_id' => 4, 'type' => 'Desa'],
            ['name' => 'Sabang Subik',       'district_id' => 4, 'type' => 'Desa'],
            ['name' => 'Tammajarra',       'district_id' => 4, 'type' => 'Desa'],
            ['name' => 'Tammangalle',       'district_id' => 4, 'type' => 'Desa'],

            // Kecamatan Bulo
            ['name' => 'Bulo',       'district_id' => 5, 'type' => 'Desa'],
            ['name' => 'Daala Timur',       'district_id' => 5, 'type' => 'Desa'],
            ['name' => 'Ihing',       'district_id' => 5, 'type' => 'Desa'],
            ['name' => 'Karombang',       'district_id' => 5, 'type' => 'Desa'],
            ['name' => 'Lenggo',       'district_id' => 5, 'type' => 'Desa'],
            ['name' => 'Patambanua',       'district_id' => 5, 'type' => 'Desa'],
            ['name' => 'Pulliwa',       'district_id' => 5, 'type' => 'Desa'],
            ['name' => 'Sabura',       'district_id' => 5, 'type' => 'Desa'],
            ['name' => 'Sepporaki',       'district_id' => 5, 'type' => 'Desa'],

            // Kecamatan Campalagian
            ['name' => 'Pappang',       'district_id' => 6, 'type' => 'Kelurahan'],
            ['name' => 'Bonde',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Botto',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Gattungan',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Katumbangan',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Katumbangan Lemo',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Kenje',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Lagi-Agi',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Laliko',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Lampoko',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Lapeo',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Ongko',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Padang',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Padang Timur',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Panyampa',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Parappe',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Sumarrang',       'district_id' => 6, 'type' => 'Desa'],
            ['name' => 'Suruang',       'district_id' => 6, 'type' => 'Desa'],

            // Kecamatan Limboro
            ['name' => 'Limboro',       'district_id' => 7, 'type' => 'Kelurahan'],
            ['name' => 'Lembang Lembang',       'district_id' => 7, 'type' => 'Desa'],
            ['name' => 'Napo',       'district_id' => 7, 'type' => 'Desa'],
            ['name' => 'Palece',       'district_id' => 7, 'type' => 'Desa'],
            ['name' => 'Pendulangan',       'district_id' => 7, 'type' => 'Desa'],
            ['name' => 'Renggeang',       'district_id' => 7, 'type' => 'Desa'],
            ['name' => 'Salarri',       'district_id' => 7, 'type' => 'Desa'],
            ['name' => 'Samasundu',       'district_id' => 7, 'type' => 'Desa'],
            ['name' => 'Tandasura',       'district_id' => 7, 'type' => 'Desa'],
            ['name' => 'Tangan Baru',       'district_id' => 7, 'type' => 'Desa'],
            ['name' => 'Todang Todang',       'district_id' => 7, 'type' => 'Desa'],

            // Kecamatan Luyo
            ['name' => 'Batupanga',       'district_id' => 8, 'type' => 'Kelurahan'],
            ['name' => 'Baru',       'district_id' => 8, 'type' => 'Desa'],
            ['name' => 'Batupanga Daala',       'district_id' => 8, 'type' => 'Desa'],
            ['name' => 'Luyo',       'district_id' => 8, 'type' => 'Desa'],
            ['name' => 'Mambu',       'district_id' => 8, 'type' => 'Desa'],
            ['name' => 'Mapili Barat',       'district_id' => 8, 'type' => 'Desa'],
            ['name' => 'Puccadi',       'district_id' => 8, 'type' => 'Desa'],
            ['name' => 'Pussui',       'district_id' => 8, 'type' => 'Desa'],
            ['name' => 'Pussui Barat',       'district_id' => 8, 'type' => 'Desa'],
            ['name' => 'Sambali Wali',       'district_id' => 8, 'type' => 'Desa'],
            ['name' => 'Tenggelang',       'district_id' => 8, 'type' => 'Desa'],

            // Kecamatan Mapilli
            ['name' => 'Mapilli',       'district_id' => 9, 'type' => 'Kelurahan'],
            ['name' => 'Beroangin',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Bonne-Bonne',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Bonra',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Buku',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Kurma',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Landi Kanusuang',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Rappang Barat',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Rumpa',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Sattoko',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Segerang',       'district_id' => 9, 'type' => 'Desa'],
            ['name' => 'Ugibaru',       'district_id' => 9, 'type' => 'Desa'],

            // Kecamatan Matakali
            ['name' => 'Matakali',       'district_id' => 10, 'type' => 'Kelurahan'],
            ['name' => 'Barumbung',       'district_id' => 10, 'type' => 'Desa'],
            ['name' => 'Bunga-Bunga',       'district_id' => 10, 'type' => 'Desa'],
            ['name' => 'Indomakkombong',       'district_id' => 10, 'type' => 'Desa'],
            ['name' => 'Pasiang',       'district_id' => 10, 'type' => 'Desa'],
            ['name' => 'Patampanua',       'district_id' => 10, 'type' => 'Desa'],
            ['name' => 'Tonrolima',       'district_id' => 10, 'type' => 'Desa'],

            // Kecamatan Matangnga
            ['name' => 'Matangnga',       'district_id' => 11, 'type' => 'Kelurahan'],
            ['name' => "Ba'ba Tapua",       'district_id' => 11, 'type' => 'Desa'],
            ['name' => 'Katimbang',       'district_id' => 11, 'type' => 'Desa'],
            ['name' => 'lilli',       'district_id' => 11, 'type' => 'Desa'],
            ['name' => 'Mambu Tapua',       'district_id' => 11, 'type' => 'Desa'],
            ['name' => 'Rangoan',       'district_id' => 11, 'type' => 'Desa'],
            ['name' => 'Tapua',       'district_id' => 11, 'type' => 'Desa'],

            // Kecamatan Polewali
            ['name' => 'Darma',       'district_id' => 12, 'type' => 'Kelurahan'],
            ['name' => 'Lantora',     'district_id' => 12, 'type' => 'Kelurahan'],
            ['name' => 'Madate',     'district_id' => 12, 'type' => 'Kelurahan'],
            ['name' => 'Manding',     'district_id' => 12, 'type' => 'Kelurahan'],
            ['name' => 'Pekkabata',   'district_id' => 12, 'type' => 'Kelurahan'],
            ['name' => 'Polewali',    'district_id' => 12, 'type' => 'Kelurahan'],
            ['name' => 'Sulewatang',  'district_id' => 12, 'type' => 'Kelurahan'],
            ['name' => 'Takatidung',  'district_id' => 12, 'type' => 'Kelurahan'],
            ['name' => 'Wattang',     'district_id' => 12, 'type' => 'Kelurahan'],

            // kecamatan Tapango
            ['name' => 'Pelitakan',     'district_id' => 13, 'type' => 'Kelurahan'],
            ['name' => 'Banato Rejo',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Batu',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Bussu',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Dakka',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Jambu Malea',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Kalimbua',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Kurrak',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Palatta',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Rappang',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Riso',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Tapango',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Tapango Barat',     'district_id' => 13, 'type' => 'Desa'],
            ['name' => 'Tuttula',     'district_id' => 13, 'type' => 'Desa'],

            // Kecamatan Tinambung
            ['name' => 'Tinambung',     'district_id' => 14, 'type' => 'Kelurahan'],
            ['name' => 'Batulaya',     'district_id' => 14, 'type' => 'Desa'],
            ['name' => 'Galung Lombok',     'district_id' => 14, 'type' => 'Desa'],
            ['name' => 'Karama',     'district_id' => 14, 'type' => 'Desa'],
            ['name' => 'Lekopadis',     'district_id' => 14, 'type' => 'Desa'],
            ['name' => 'Sepabatu',     'district_id' => 14, 'type' => 'Desa'],
            ['name' => 'Tandung',     'district_id' => 14, 'type' => 'Desa'],
            ['name' => 'Tangnga-Tangnga',     'district_id' => 14, 'type' => 'Desa'],

            // Kecamatan Tutar
            ['name' => 'Taramanu',     'district_id' => 15, 'type' => 'Kelurahan'],
            ['name' => 'Ampopadang',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Arabua',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Besoangin',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Besoangin Utara',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Peburru',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Piriang Tapiako',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Poda',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Pollewani',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Ratte',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Taloba',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Taramanu Tua',     'district_id' => 15, 'type' => 'Desa'],
            ['name' => 'Tubbi',     'district_id' => 15, 'type' => 'Desa'],


            // kecamatan Wonomulyo 
            ['name' => 'Sidodadi',    'district_id' => 16, 'type' => 'Kelurahan'],
            ['name' => 'Arjosari',    'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Bakka-Bakka', 'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Banua Baru',  'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Bumiayu',     'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Bumimulyo',   'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Campurejo',    'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Galeso',    'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Kebunsari',    'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Nepo',    'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Sidorejo',    'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Sugihwaras',    'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Sumberejo',    'district_id' => 16, 'type' => 'Desa'],
            ['name' => 'Tumpiling',    'district_id' => 16, 'type' => 'Desa'],
        ];


        // Jika tidak menggunakan $allNames, kita gunakan $prefill (contoh). Kamu bisa ganti/lanjutkan array ini
        foreach ($prefill as $item) {
            // pastikan unik (hindari duplicate di seeder run ulang)
            if (DB::table('villages')->where('name', $item['name'])->exists()) {
                continue;
            }
            DB::table('villages')->insert([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'district_id' => $item['district_id'],
                'type' => $item['type'],
                'geojson' => null,
                'color' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
