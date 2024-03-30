<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Day;



class DaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            ['name' => 'Monday'],
            ['name' => 'Tuesday'],
            ['name' => 'Wednesday'],
            ['name' => 'Thursday'],
            ['name' => 'Friday'],
            ['name' => 'Saturday'],
            ['name' => 'Sunday'],
        ];

        foreach ($days as $day) {
            Day::create($day);
        }
    }
}
