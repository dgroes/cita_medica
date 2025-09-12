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
                //User id: 12 (Stannis Baratheon)
                'user_id' => 12,
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
                //User id: 13 (Melisandre)
                'user_id' => 13,
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
                //User id: 14 (Oberyn Martell)
                'user_id' => 14,
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
                // User id: 15 (Jorah Mormont)
                'user_id' => 15,
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
                // User id: 16 (Missandei)
                'user_id' => 16,
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
                // User id: 17 (Jon Snow)
                'user_id' => 17,
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
                // User id: 18 (Sansa Stark)
                'user_id' => 18,
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
                // User id: 19 (Eddard Stark)
                'user_id' => 19,
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
                // User id: 20 (Daenerys Targaryen)
                'user_id' => 20,
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
                // User id: 21 (Robb Stark)
                'user_id' => 21,
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
                // User id: 22 (Cersei Lannister)
                'user_id' => 22,
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
                // User id: 23 (Jaime Lannister)
                'user_id' => 23,
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
                // User id: 24 (Theon Greyjoy)
                'user_id' => 24,
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
                // User id: 25 (Ygritte)
                'user_id' => 25,
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
                // User id: 26 (Tormund Giantsbane)
                'user_id' => 26,
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
            [
                // Benjen Stark (user_id: 27)
                'user_id' => 27,
                'blood_type_id' => 2, // A- (Stark suelen ser A-)
                'allergies' => 'Ninguna conocida',
                'chronic_conditions' => 'Hipotermia recurrente',
                'surgical_history' => 'Herida de puñal en el abdomen durante patrulla',
                'family_history' => 'Familia con predisposición a problemas circulatorios en climas fríos',
                'observations' => 'Ranger experimentado, resistencia al frío superior al promedio',
                'emergency_contact_name' => 'Jon Snow',
                'emergency_contact_relationship' => 'Sobrino',
                'emergency_contact_phone' => '56965432101',
                'date_of_birth' => '1968-03-15',
                'photo' => null,
            ],
            [
                // Jojen Reed (user_id: 28)
                'user_id' => 28,
                'blood_type_id' => 4, // B- (misterioso como los Reed)
                'allergies' => 'Polen de arciano',
                'chronic_conditions' => 'Epilepsia visionaria',
                'surgical_history' => null,
                'family_history' => 'Historia familiar de habilidades greensight',
                'observations' => 'Visiones recurrentes, requiere monitoreo neurológico',
                'emergency_contact_name' => 'Howland Reed',
                'emergency_contact_relationship' => 'Padre',
                'emergency_contact_phone' => '56965432102',
                'date_of_birth' => '2005-08-22',
                'photo' => null,
            ],
            [
                // Meera Reed (user_id: 29)
                'user_id' => 29,
                'blood_type_id' => 4, // B- (como su hermano)
                'allergies' => null,
                'chronic_conditions' => 'Estrés post-traumático',
                'surgical_history' => 'Fractura de brazo en combate',
                'family_history' => 'Familia de guerreros anfibios, buena salud general',
                'observations' => 'Excelente condición física, experta en supervivencia',
                'emergency_contact_name' => 'Howland Reed',
                'emergency_contact_relationship' => 'Padre',
                'emergency_contact_phone' => '56965432103',
                'date_of_birth' => '2003-05-14',
                'photo' => null,
            ],
            [
                // Euron Greyjoy (user_id: 30)
                'user_id' => 30,
                'blood_type_id' => 3, // B+ (sanguíneo y agresivo)
                'allergies' => 'Ninguna',
                'chronic_conditions' => 'Trastorno de personalidad antisocial',
                'surgical_history' => 'Herida ocular en batalla naval',
                'family_history' => 'Historia familiar de tendencias violentas',
                'observations' => 'Paciente de alto riesgo, comportamiento impredecible',
                'emergency_contact_name' => 'Aerion Greyjoy',
                'emergency_contact_relationship' => 'Hermano',
                'emergency_contact_phone' => '56965432104',
                'date_of_birth' => '1975-11-30',
                'photo' => null,
            ],
            [
                // Balon Greyjoy (user_id: 31)
                'user_id' => 31,
                'blood_type_id' => 7, // O+ (viejo y terco)
                'allergies' => 'Mariscos (ironicamente)',
                'chronic_conditions' => 'Artritis reumatoide, hipertensión',
                'surgical_history' => 'Múltiples fracturas por caídas en rocas',
                'family_history' => 'Enfermedades cardíacas en línea paterna',
                'observations' => 'Paciente testarudo, no sigue tratamientos al pie de la letra',
                'emergency_contact_name' => 'Alannys Harlaw',
                'emergency_contact_relationship' => 'Esposa',
                'emergency_contact_phone' => '56965432105',
                'date_of_birth' => '1958-09-08',
                'photo' => null,
            ],
            [
                // Victarion Greyjoy (user_id: 32)
                'user_id' => 32,
                'blood_type_id' => 7, // O+ (guerrero fuerte)
                'allergies' => null,
                'chronic_conditions' => 'Pérdida auditiva parcial por explosiones',
                'surgical_history' => 'Brazo quemado y posterior amputación',
                'family_history' => 'Familia de marineros robustos',
                'observations' => 'Fuerza física notable, tolerancia al dolor elevada',
                'emergency_contact_name' => 'Euron Greyjoy',
                'emergency_contact_relationship' => 'Hermano',
                'emergency_contact_phone' => '56965432106',
                'date_of_birth' => '1972-12-25',
                'photo' => null,
            ],
            [
                // Rodrik Cassel (user_id: 33)
                'user_id' => 33,
                'blood_type_id' => 1, // A+ (leal y ordenado)
                'allergies' => 'Polvo de establo',
                'chronic_conditions' => 'Lumbalgia crónica por uso de armadura',
                'surgical_history' => 'Múltiples heridas de espada',
                'family_history' => 'Familia de soldados, buena salud general',
                'observations' => 'Veterano confiable, sigue instrucciones médicas',
                'emergency_contact_name' => 'Beth Cassel',
                'emergency_contact_relationship' => 'Hija',
                'emergency_contact_phone' => '56965432107',
                'date_of_birth' => '1965-07-19',
                'photo' => null,
            ],
            [
                // Jory Cassel (user_id: 34)
                'user_id' => 34,
                'blood_type_id' => 1, // A+ (como su tío)
                'allergies' => null,
                'chronic_conditions' => null,
                'surgical_history' => 'Herida superficial en rostro',
                'family_history' => 'Misma línea familiar que Rodrik',
                'observations' => 'Joven saludable, buen estado físico',
                'emergency_contact_name' => 'Rodrik Cassel',
                'emergency_contact_relationship' => 'Tío',
                'emergency_contact_phone' => '56965432108',
                'date_of_birth' => '1988-04-12',
                'photo' => null,
            ],
            [
                // Roose Bolton (user_id: 35)
                'user_id' => 35,
                'blood_type_id' => 8, // O- (frío y calculador)
                'allergies' => 'Lana de oveja',
                'chronic_conditions' => 'Hipocondría, problemas digestivos',
                'surgical_history' => 'Extracción de verruga maligna',
                'family_history' => 'Historia de enfermedades de piel en familia',
                'observations' => 'Paciente reservado, poco expresivo con síntomas',
                'emergency_contact_name' => 'Walda Frey',
                'emergency_contact_relationship' => 'Esposa',
                'emergency_contact_phone' => '56965432109',
                'date_of_birth' => '1960-10-31',
                'photo' => null,
            ],
            [
                // Ramsay Bolton (user_id: 36)
                'user_id' => 36,
                'blood_type_id' => 8, // O- (como su padre)
                'allergies' => 'Perros (irónico para su hobby)',
                'chronic_conditions' => 'Trastorno de personalidad límite',
                'surgical_history' => 'Múltiples heridas autoinfligidas',
                'family_history' => 'Historia psiquiátrica familiar',
                'observations' => 'Paciente de alto riesgo, requiere supervisión constante',
                'emergency_contact_name' => 'Roose Bolton',
                'emergency_contact_relationship' => 'Padre',
                'emergency_contact_phone' => '56965432110',
                'date_of_birth' => '1989-06-20',
                'photo' => null,
            ],
            [
                // Walder Frey (user_id: 37)
                'user_id' => 37,
                'blood_type_id' => 5, // AB+ (raro como él)
                'allergies' => 'Casi todo (viejo y delicado)',
                'chronic_conditions' => 'Artritis, gota, problemas de próstata',
                'surgical_history' => 'Extracción de cálculos renales',
                'family_history' => 'Longevidad extrema en familia',
                'observations' => 'Paciente anciano con múltiples comorbilidades',
                'emergency_contact_name' => 'Perwyn Frey',
                'emergency_contact_relationship' => 'Hijo',
                'emergency_contact_phone' => '56965432111',
                'date_of_birth' => '1920-01-15',
                'photo' => null,
            ],
            [
                // Brynden Tully (user_id: 38)
                'user_id' => 38,
                'blood_type_id' => 2, // A- (pez negro rebelde)
                'allergies' => null,
                'chronic_conditions' => 'Problemas de visión por edad',
                'surgical_history' => 'Herida de flecha en hombro',
                'family_history' => 'Familia de pescadores, buena salud cardiovascular',
                'observations' => 'Veterano en buena forma para su edad',
                'emergency_contact_name' => 'Edmure Tully',
                'emergency_contact_relationship' => 'Sobrino',
                'emergency_contact_phone' => '56965432112',
                'date_of_birth' => '1955-03-03',
                'photo' => null,
            ],
            [
                // Edmure Tully (user_id: 39)
                'user_id' => 39,
                'blood_type_id' => 2, // A- (como su tío)
                'allergies' => 'Pescado de río (ironicamente)',
                'chronic_conditions' => 'Ansiedad crónica',
                'surgical_history' => 'Fractura de nariz en torneo',
                'family_history' => 'Misma línea Tully',
                'observations' => 'Paciente nervioso, requiere abordaje calmado',
                'emergency_contact_name' => 'Roslin Frey',
                'emergency_contact_relationship' => 'Esposa',
                'emergency_contact_phone' => '56965432113',
                'date_of_birth' => '1982-11-28',
                'photo' => null,
            ],
            [
                // Loras Tyrell (user_id: 40)
                'user_id' => 40,
                'blood_type_id' => 5, // AB+ (caballero exótico)
                'allergies' => 'Polen de rosas',
                'chronic_conditions' => null,
                'surgical_history' => 'Múltiples heridas de justas',
                'family_history' => 'Familia longeva y saludable',
                'observations' => 'Atleta de elite, excelente condición física',
                'emergency_contact_name' => 'Margaery Tyrell',
                'emergency_contact_relationship' => 'Hermana',
                'emergency_contact_phone' => '56965432114',
                'date_of_birth' => '1992-08-10',
                'photo' => null,
            ],
            [
                // Margaery Tyrell (user_id: 41)
                'user_id' => 41,
                'blood_type_id' => 5, // AB+ (como su hermano)
                'allergies' => 'Mariscos',
                'chronic_conditions' => null,
                'surgical_history' => null,
                'family_history' => 'Misma línea Tyrell',
                'observations' => 'Paciente saludable, inteligente y cooperativa',
                'emergency_contact_name' => 'Olenna Tyrell',
                'emergency_contact_relationship' => 'Abuela',
                'emergency_contact_phone' => '56965432115',
                'date_of_birth' => '1994-12-25',
                'photo' => null,
            ],
            [
                // Olenna Tyrell (user_id: 42)
                'user_id' => 42,
                'blood_type_id' => 5, // AB+ (matriarca Tyrell)
                'allergies' => 'Estupidez humana (según ella)',
                'chronic_conditions' => 'Artritis, pérdida auditiva leve',
                'surgical_history' => 'Extracción de vesícula',
                'family_history' => 'Longevidad y agudeza mental familiar',
                'observations' => 'Paciente lúcida pero sarcástica, mente brillante',
                'emergency_contact_name' => 'Mace Tyrell',
                'emergency_contact_relationship' => 'Hijo',
                'emergency_contact_phone' => '56965432116',
                'date_of_birth' => '1940-06-18',
                'photo' => null,
            ],
            [
                // Doran Martell (user_id: 43)
                'user_id' => 43,
                'blood_type_id' => 6, // AB- (exótico como Dorne)
                'allergies' => 'Calor extremo',
                'chronic_conditions' => 'Gota severa, movilidad reducida',
                'surgical_history' => null,
                'family_history' => 'Enfermedades reumáticas familiares',
                'observations' => 'Paciente de movilidad limitada, mente aguda',
                'emergency_contact_name' => 'Areo Hotah',
                'emergency_contact_relationship' => 'Guardaespaldas',
                'emergency_contact_phone' => '56965432117',
                'date_of_birth' => '1962-09-05',
                'photo' => null,
            ],
            [
                // Trystane Martell (user_id: 44)
                'user_id' => 44,
                'blood_type_id' => 6, // AB- (como su padre)
                'allergies' => 'Polvo del desierto',
                'chronic_conditions' => null,
                'surgical_history' => null,
                'family_history' => 'Misma línea Martell',
                'observations' => 'Joven saludable, educado y cooperativo',
                'emergency_contact_name' => 'Doran Martell',
                'emergency_contact_relationship' => 'Padre',
                'emergency_contact_phone' => '56965432118',
                'date_of_birth' => '1998-02-14',
                'photo' => null,
            ],
            [
                // Ellaria Sand (user_id: 45)
                'user_id' => 45,
                'blood_type_id' => 4, // B- (sangre de arena)
                'allergies' => null,
                'chronic_conditions' => 'Estrés post-traumático',
                'surgical_history' => null,
                'family_history' => 'Familia de bastardos saludables',
                'observations' => 'Paciente emocionalmente compleja, requiere apoyo psicológico',
                'emergency_contact_name' => 'Obara Sand',
                'emergency_contact_relationship' => 'Hija',
                'emergency_contact_phone' => '56965432119',
                'date_of_birth' => '1978-07-30',
                'photo' => null,
            ],
            [
                // Quentyn Martell (user_id: 46)
                'user_id' => 46,
                'blood_type_id' => 6, // AB- (como su familia)
                'allergies' => 'Pelo de dragón (demasiado literal)',
                'chronic_conditions' => 'Timidez social',
                'surgical_history' => 'Quemaduras severas múltiples',
                'family_history' => 'Misma línea Martell',
                'observations' => 'Paciente con cicatrices extensas, requiere cuidado dermatológico',
                'emergency_contact_name' => 'Doran Martell',
                'emergency_contact_relationship' => 'Padre',
                'emergency_contact_phone' => '56965432120',
                'date_of_birth' => '1996-04-01',
                'photo' => null,
            ]



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
