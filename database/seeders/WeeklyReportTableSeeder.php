<?php

namespace Database\Seeders;

use App\Models\WeeklyReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeeklyReportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weeklyReports = [
            [
                'simkopdes' => 50,
                'nib' => 10,
                'npwp' => 8,
                'bank_account' => 5,
                'business_activity_plan' => 0,
                'financing_proposal' => 3,
                'ods' => 17,
                'number_of_member' => 100,
                'created_at' => '2025/10/30',
                'updated_at' => '2025/10/30',
            ],
            [
                'simkopdes' => 150,
                'nib' => 30,
                'npwp' => 123,
                'bank_account' => 10,
                'business_activity_plan' => 5,
                'financing_proposal' => 5,
                'ods' => 35,
                'number_of_member' => 1000,
                'created_at' => '2025/11/30',
                'updated_at' => '2025/11/30',
            ],
            [
                'simkopdes' => 167,
                'nib' => 52,
                'npwp' => 150,
                'bank_account' => 17,
                'business_activity_plan' => 35,
                'financing_proposal' => 7,
                'ods' => 50,
                'number_of_member' => 1900,
                'created_at' => '2025/12/19',
                'updated_at' => '2025/12/19',
            ]
        ];

        foreach ($weeklyReports as $week) {
            WeeklyReport::create($week);
        }
    }
}
