<?php

namespace Database\Seeders;

use App\Enums\AppointmentEnum;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener Doctores y Pacientes
        $doctors = Doctor::whereNotIn('user_id', [1, 2, 3])->get(); // Excluye los primeros 3 (Davos: Admin | Aemon y Daeron: Recepcionista)
        $patients = Patient::whereBetween('user_id', [10, 24])->get();

        // Rango de fechas: lunes de la semana pasada hasta domingo de la próxima
        $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->subWeek(); // semana pasada
        $endDate   = (clone $startDate)->addWeeks(3)->endOfWeek(Carbon::SUNDAY); // hasta fin de próxima

        $now = Carbon::now();

        foreach (range(1, 100) as $i) { // 100 citas de ejemplo
            $doctor  = $doctors->random();
            $patient = $patients->random();

            // Buscar día aleatorio que no sea domingo
            do {
                $date = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp))
                    ->startOfDay();
            } while ($date->isSunday()); // excluye domingos

            // Hora aleatoria (08:00 - 16:45 en bloques de 15 min)
            $startHour   = rand(8, 16);
            $startMinute = [0, 15, 30, 45][array_rand([0, 15, 30, 45])];
            $start       = Carbon::createFromTime($startHour, $startMinute, 0, $date->timezone)
                ->setDate($date->year, $date->month, $date->day);
            $end         = (clone $start)->addMinutes(15);

            // Por defecto programada
            $status = AppointmentEnum::SCHEDULED;

            // Definir estado según fecha/hora
            if ($end->lt($now)) {
                // Citas en el pasado → completadas
                $status = AppointmentEnum::COMPLETED;
            } elseif ($start->gt($now) && rand(1, 100) <= 9) {
                // ~9% de las futuras → canceladas
                $status = AppointmentEnum::CANCELLED;
            }

            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id'  => $doctor->id,
                'date'       => $date,
                'start_time' => $start->format('H:i:s'),
                'end_time'   => $end->format('H:i:s'),
                'duration'   => 15,
                'reason'     => fake()->sentence(),
                'status'     => $status,
            ]);

            // Crear consulta vacía
            $appointment->consultation()->create([]);

            // Si está completada, rellenamos consulta
            if ($status === AppointmentEnum::COMPLETED) {
                $appointment->consultation()->update([
                    'diagnosis'     => fake()->sentence(),
                    'treatment'     => fake()->sentence(),
                    'notes'         => fake()->paragraph(),
                    'prescriptions' => json_encode([[
                        'dosage'    => '3 Litros al día',
                        'medicine'  => 'Leche de amapola',
                        'frequency' => 'Por 6 días'
                    ]]),
                ]);
            }
        }
    }
}
