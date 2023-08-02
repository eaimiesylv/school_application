<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfRecordsPerClass = 10;

        // Loop through class_id 7 to 10 and create records for each class_id
        for ($classId = 7; $classId <= 10; $classId++) {
           \App\Models\Student::factory()->count($numberOfRecordsPerClass)->create([
                'class_id' => $classId,
            ]);
        }
    }
}
