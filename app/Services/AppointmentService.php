<?php

namespace App\Services;

use App\Models\Doctor;
use Carbon\Carbon;

class AppointmentService
{
    /* C50: Buscador de citas médicas (2) */
    public function searchAvailability($date, $hour, $speciality_id)
    {
        // dd([
        // 'date' => $date,
        // 'hour' => $hour,
        // 'speciality_id' => $speciality_id,
        // ]);

        $date = Carbon::parse($date);
        $hourStart = Carbon::parse($hour)->format('H:i:s');
        $hourEnd = Carbon::parse($hour)->addHour()->format('H:i:s');

        $doctors = Doctor::whereHas('schedules', function ($q) use ($date, $hourStart, $hourEnd) {
            $q->where('day_of_week', $date->dayOfWeek)
                ->where('start_time', '>=', $hourStart)
                ->where('start_time', '<', $hourEnd);
        })
            ->when($speciality_id, function ($q, $speciality_id) {
                return $q->where('speciality_id', $speciality_id);
            })
            ->with([
                'user',
                'speciality',
                'schedules' => function ($q) use ($date, $hourStart, $hourEnd) {
                    $q->where('day_of_week', $date->dayOfWeek)
                        ->where('start_time', '>=', $hourStart)
                        ->where('start_time', '<', $hourEnd);
                },
                'appointments' => function ($q) use ($date, $hourStart, $hourEnd) {
                    $q->whereDate('date', $date)
                        ->where('start_time', '>=', $hourStart)
                        ->where('start_time', '<', $hourEnd);
                }
            ])
            ->get();
        // dd($doctors->toArray());
        return $doctors;
    }


}
