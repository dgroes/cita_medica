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
            // recorrer los días de la semana (1=lunes, 6=sábado)

            foreach (range(1, 6) as $day) { // lunes a sábado

                // Obtener los horarios desde la configuración
                $startTime = config('schedule.start_time');
                $endTime = config('schedule.end_time');
                $appointmentDuration = config('schedule.appointment_duration');

                // Convertir a objetos Carbon
                $start = Carbon::createFromTimeString($startTime);
                $end = Carbon::createFromTimeString($endTime);

                // Generar intervalos de acuerdo a la duración configurada
                while ($start->lt($end)) {
                    Schedule::create([
                        'doctor_id'   => $doctor->id,
                        'day_of_week' => $day,
                        'start_time'  => $start->format('H:i:s'),
                    ]);

                    // Se avanza según la duración configurada
                    $start->addMinutes($appointmentDuration);
                }
            }
        }
    }
}
