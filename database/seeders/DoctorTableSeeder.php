<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::factory()->count(30)->create();
        $Appointments = Appointment::all();

//        Doctor::all()->each(function ($doctor) use ($Appointments) {
//            $doctor->appointments()->attach(
//                $Appointments->random(rand(1, 7))->pluck('id')->toArray()
//            );
//        });

        foreach ($doctors as $doctor) {
            $doctor->appointments()->attach(
                $Appointments->random(rand(1, 7))->pluck('id')->toArray()
            );
        }
    }
}
