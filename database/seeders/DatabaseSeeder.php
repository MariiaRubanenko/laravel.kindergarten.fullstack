<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use App\Models\Child_profile;
use App\Models\Attendance;
use Database\Seeders\DaySeeder;
use Illuminate\Database\Seeder;
use Database\Factories\ChildProfileFactory;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        //Сидеры 
        //Позволяет одним действием заполнить базу данных необходимыми данными при каждом запуске сида,
        // чтобы запускался и  UserSeeder,
        // $this->call(UserSeeder::class);

        //  $this->call(DaysSeeder::class);
        
        //Фабрики
        //ChildProfileFactory::factory(8)->create();
        // ChildProfileFactory::new()->count(8)->create();
        // Attendance::factory(15)->create();


        
    }
}
