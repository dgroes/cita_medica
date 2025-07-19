<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                //User id: 10 (Stannis Baratheon)
                'user_id' => 10,
                'blood_type_id' => 1, // Tipo de sangre A+
                'allergies' => null, // Sin alergias
                'chronic_conditions' => null, // Sin condiciones crónicas
                'surgical_history' => null, // Sin historial quirúrgico
                'family_history' => null, // Sin historial familiar
                'observations' => null, // Sin observaciones adicionales
                'emergency_contact_name' => 'Robert Baratheon',
                'emergency_contact_relationship' => 'Hermano',
                'emergency_contact_phone' => '56912345678',
                'date_of_birth' => '1980-01-01', // Fecha de nacimiento
                'photo' => null, // Sin foto del paciente
            ],
            [
                //User id: 11 (Melisandre)
                'user_id' => 11,
                'blood_type_id' => 2, // Tipo de sangre A-
                'allergies' => 'Pollen', // Alergia al polen
                'chronic_conditions' => null, // Sin condiciones crónicas
                'surgical_history' => null, // Sin historial quirúrgico
                'family_history' => null, // Sin historial familiar
                'observations' => null, // Sin observaciones adicionales
                'emergency_contact_name' => 'Davos Seaworth',
                'emergency_contact_relationship' => 'Amigo',
                'emergency_contact_phone' => '56987654321',
                'date_of_birth' => '1990-05-15', // Fecha de nacimiento
                'photo' => null, // Sin foto del paciente
            ],
            [
                //User id: 12 (Oberyn Martell)
                'user_id' => 11,
                'blood_type_id' => 2, // Tipo de sangre A-
                'allergies' => 'Pollen',
                'chronic_conditions' => null,
                'surgical_history' => null,
                'family_history' => null,
                'observations' => null,
                'emergency_contact_name' => 'Doran Martell',
                'emergency_contact_relationship' => 'Hermano',
                'emergency_contact_phone' => '56999954321',
                'date_of_birth' => '1994-09-12',
                'photo' => null,
            ],
            [
                // User id: 13 (Jorah Mormont)
                'user_id' => 13,
                'blood_type_id' => 3, // Tipo de sangre B+
                'allergies' => null,
                'chronic_conditions' => 'Greyscale (remisión)',
                'surgical_history' => 'Tratamiento experimental en Essos',
                'family_history' => 'Padre con problemas neurológicos',
                'observations' => 'Paciente fue curado de greyscale mediante técnicas no convencionales',
                'emergency_contact_name' => 'Daenerys Targaryen',
                'emergency_contact_relationship' => 'Reina / Protectora',
                'emergency_contact_phone' => '56912398765',
                'date_of_birth' => '1975-06-04',
                'photo' => null,
            ],
            [
                // User id: 14 (Missandei)
                'user_id' => 14,
                'blood_type_id' => 5, // Tipo de sangre AB+
                'allergies' => 'Polvo de dragón (irritación leve)',
                'chronic_conditions' => null,
                'surgical_history' => null,
                'family_history' => 'Madre fallecida por enfermedad respiratoria',
                'observations' => 'Ansiedad leve en espacios cerrados',
                'emergency_contact_name' => 'Daenerys Targaryen',
                'emergency_contact_relationship' => 'Confidente',
                'emergency_contact_phone' => '56976543210',
                'date_of_birth' => '1991-08-22',
                'photo' => null,
            ],
            [
                // User id: 15 (Jon Snow)
                'user_id' => 15,
                'blood_type_id' => 1, // A+
                'allergies' => 'Frío extremo (urticaria leve)',
                'chronic_conditions' => 'Post-estrés traumático',
                'surgical_history' => 'Herida por apuñalamiento múltiple en tórax',
                'family_history' => 'Madre desconocida, historial incompleto',
                'observations' => 'Resucitado tras muerte clínica. Marcas de trauma profundo',
                'emergency_contact_name' => 'Samwell Tarly',
                'emergency_contact_relationship' => 'Amigo cercano',
                'emergency_contact_phone' => '56991122334',
                'date_of_birth' => '1986-12-03',
                'photo' => null,
            ],
            [
                // User id: 16 (Sansa Stark)
                'user_id' => 16,
                'blood_type_id' => 8, // 0-
                'allergies' => null,
                'chronic_conditions' => null,
                'surgical_history' => null,
                'family_history' => 'Madre con antecedentes depresivos',
                'observations' => 'Paciente con historial de trauma psicológico severo',
                'emergency_contact_name' => 'Arya Stark',
                'emergency_contact_relationship' => 'Hermana',
                'emergency_contact_phone' => '56944556677',
                'date_of_birth' => '1992-07-09',
                'photo' => null,
            ],
            [
                // User id: 17 (Eddard Stark)
                'user_id' => 17,
                'blood_type_id' => 7, // O+
                'allergies' => null,
                'chronic_conditions' => 'Dolor crónico cervical (producto de tortura)',
                'surgical_history' => 'Antigua fractura de pierna curada',
                'family_history' => 'Padre falleció de fiebre del pantano',
                'observations' => 'Paciente con historial de encarcelamiento y decapitación no completada',
                'emergency_contact_name' => 'Catelyn Stark',
                'emergency_contact_relationship' => 'Esposa',
                'emergency_contact_phone' => '56999887766',
                'date_of_birth' => '1960-02-15',
                'photo' => null,
            ],
            [
                // User id: 18 (Daenerys Targaryen)
                'user_id' => 18,
                'blood_type_id' => 5, // AB+
                'allergies' => 'Incienso de fuego valyrio',
                'chronic_conditions' => 'Hipersensibilidad emocional',
                'surgical_history' => 'Quemaduras leves (no cicatrices)',
                'family_history' => 'Antecedentes de psicosis familiar',
                'observations' => 'Inmune al fuego en ciertos contextos. Necesita control emocional frecuente',
                'emergency_contact_name' => 'Tyrion Lannister',
                'emergency_contact_relationship' => 'Consejero',
                'emergency_contact_phone' => '56988776655',
                'date_of_birth' => '1989-03-04',
                'photo' => null,
            ],
            [
                // User id: 19 (Robb Stark)
                'user_id' => 19,
                'blood_type_id' => 4, // B-
                'allergies' => null,
                'chronic_conditions' => null,
                'surgical_history' => 'Heridas de batalla cicatrizadas',
                'family_history' => 'Padre decapitado, madre asesinada',
                'observations' => 'Paciente sufrió trauma físico y emocional. Murió joven',
                'emergency_contact_name' => 'Talisa Maegyr',
                'emergency_contact_relationship' => 'Esposa',
                'emergency_contact_phone' => '56990909090',
                'date_of_birth' => '1988-11-30',
                'photo' => null,
            ],
            [
                // User id: 20 (Cersei Lannister)
                'user_id' => 20,
                'blood_type_id' => 3, // B+
                'allergies' => 'Perfumes fuertes',
                'chronic_conditions' => 'Paranoia crónica',
                'surgical_history' => null,
                'family_history' => 'Madre con antecedentes de locura',
                'observations' => 'Paciente muestra signos de inestabilidad emocional severa',
                'emergency_contact_name' => 'Jaime Lannister',
                'emergency_contact_relationship' => 'Hermano / Pareja',
                'emergency_contact_phone' => '56960001111',
                'date_of_birth' => '1979-10-05',
                'photo' => null,
            ],
            [
                // User id: 21 (Jaime Lannister)
                'user_id' => 21,
                'blood_type_id' => 3, // B+
                'allergies' => null,
                'chronic_conditions' => 'Dolor fantasma en extremidad amputada',
                'surgical_history' => 'Amputación de mano derecha',
                'family_history' => 'Padre con hipertensión',
                'observations' => 'Paciente utiliza prótesis. Terapia física requerida',
                'emergency_contact_name' => 'Brienne de Tarth',
                'emergency_contact_relationship' => 'Aliada',
                'emergency_contact_phone' => '56942233445',
                'date_of_birth' => '1978-12-01',
                'photo' => null,
            ],
            [
                // User id: 22 (Theon Greyjoy)
                'user_id' => 22,
                'blood_type_id' => 1, // A+
                'allergies' => 'Dolor crónico en zona perineal',
                'chronic_conditions' => 'Estrés postraumático severo',
                'surgical_history' => 'Castración',
                'family_history' => 'Padre con antecedentes psiquiátricos',
                'observations' => 'Paciente requiere acompañamiento psicológico intensivo',
                'emergency_contact_name' => 'Yara Greyjoy',
                'emergency_contact_relationship' => 'Hermana',
                'emergency_contact_phone' => '56945556677',
                'date_of_birth' => '1985-04-16',
                'photo' => null,
            ],
            [
                // User id: 23 (Ygritte)
                'user_id' => 23,
                'blood_type_id' => 2, // A+
                'allergies' => 'Hierbas del norte',
                'chronic_conditions' => null,
                'surgical_history' => 'Herida de flecha en hombro izquierdo',
                'family_history' => 'Desconocido (pueblo libre)',
                'observations' => 'Rehabilitada tras herida por flecha. Muerte confirmada en batalla',
                'emergency_contact_name' => 'Jon Snow',
                'emergency_contact_relationship' => 'Pareja',
                'emergency_contact_phone' => '56912312312',
                'date_of_birth' => '1990-11-20',
                'photo' => null,
            ],
            [
                // User id: 24 (Tormund Giantsbane)
                'user_id' => 24,
                'blood_type_id' => 6, // AB-
                'allergies' => null,
                'chronic_conditions' => 'Dolor lumbar crónico',
                'surgical_history' => 'Fractura de costilla en batalla',
                'family_history' => 'Padre guerrero, sin enfermedades conocidas',
                'observations' => 'Paciente fuerte y resistente, requiere control de presión arterial',
                'emergency_contact_name' => 'Jon Snow',
                'emergency_contact_relationship' => 'Aliado',
                'emergency_contact_phone' => '56965432100',
                'date_of_birth' => '1978-02-28',
                'photo' => null,
            ],
        ];
        foreach ($patients as $patient) {
            try {
                Patient::create($patient);
                $this->command->info("[OK] Paciente (user_id:{$patient['user_id']}) creado exitosamente 😷");
            } catch (\Exception $e) {
                $this->command->error("[Error] No se pudo crear el paciente {$patient['user_id']}:" . $e->getMessage());
            }
        }
    }
}
