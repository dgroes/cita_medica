<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seleccionamos solo a los usuarios que tienen rol Doctor
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            // Recorremos los días de la semana (0=domingo, 6=sábado)
            foreach (range(1, 6) as $day) { // lunes a viernes
                // Hora inicial
                $start = Carbon::createFromTime(8, 0, 0); // 08:00
                $end   = Carbon::createFromTime(17, 0, 0); // 17:00

                // Generamos intervalos de 15 minutos
                while ($start->lt($end)) {
                    Schedule::create([
                        'doctor_id'   => $doctor->id,
                        'day_of_week' => $day,
                        'start_time'  => $start->format('H:i:s'),
                    ]);

                    // Avanzamos 15 minutos
                    $start->addMinutes(15);
                }
            }
        }
    }
}
