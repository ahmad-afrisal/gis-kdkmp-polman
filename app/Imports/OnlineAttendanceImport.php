<?php

namespace App\Imports;

use App\Models\OnlineAttendance;
use App\Models\BussinessAssistant; // Pastikan model ini ada
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OnlineAttendanceImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. Cari ID Business Assistant berdasarkan Nama
        $ba = BussinessAssistant::where('name', $row['nama_ba'])->first();
        
        // Jika BA tidak ditemukan, Anda bisa skip atau handle sesuai kebutuhan
        if (!$ba) {
            return null; 
        }

        // 2. Parse Tanggal dan Jam menggunakan Carbon
        // Mengasumsikan format: YYYY-MM-DD HH:MM:SS
        $dateTime = Carbon::parse($row['tanggal']);

        // 3. Pecah Lokasi (Latitude, Longitude)
        $lat = null;
        $long = null;
        if (!empty($row['lokasi_latitude_longitude'])) {
            $coords = explode(',', $row['lokasi_latitude_longitude']);
            $lat = trim($coords[0] ?? null);
            $long = trim($coords[1] ?? null);
        }

        return new OnlineAttendance([
            'bussiness_assistant_id' => $ba->id,
            'date'                   => $dateTime->format('Y-m-d'),
            'check_in'               => $dateTime->format('H:i:s'),
            'activity'               => $row['aktivitas'],
            'latitude'               => $lat,
            'longitude'              => $long,
            'picture'                => $row['foto'], // Menyimpan URL foto dari Excel
        ]);
    }
}