<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Replace '10' with the number of records you want for each class_id
        $numberOfRecordsPerClass = 10;

        // Loop through class_id 7 to 10 and create records for each class_id
        for ($classId = 7; $classId <= 10; $classId++) {
            \App\Models\User::factory()->count($numberOfRecordsPerClass)->create([
                'class_id' => $classId,
            ]);
        }
    }
}
