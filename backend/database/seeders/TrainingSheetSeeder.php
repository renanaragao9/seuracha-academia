<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\TrainingDivision;
use App\Models\TrainingExercise;
use App\Models\TrainingSheet;
use App\Models\TrainingSheetDivision;
use App\Models\User;
use App\Models\WorkoutLog;
use App\Models\WorkoutLogExercise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TrainingSheetSeeder extends Seeder
{
    public function run(): void
    {
        $creatorId = User::query()->value('id');

        if (! $creatorId) {
            return;
        }

        $divisionIds = TrainingDivision::query()
            ->whereIn('name', ['A', 'B', 'C'])
            ->pluck('id', 'name');

        $exerciseIds = Exercise::query()
            ->whereIn('name', [
                'Supino Reto com Barra',
                'Crucifixo na Máquina',
                'Tríceps Pulley',
                'Puxada Frontal',
                'Remada Curvada com Barra',
                'Rosca Direta com Barra',
                'Agachamento Livre',
                'Leg Press 45°',
                'Panturrilha em Pé na Máquina',
            ])
            ->pluck('id', 'name');

        $students = Student::query()
            ->whereIn('code', ['ALU-0001', 'ALU-0002', 'ALU-0003', 'ALU-0004'])
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        if ($students->isEmpty()) {
            return;
        }

        $divisionTemplate = [
            'A' => [
                [
                    'name' => 'Supino Reto com Barra',
                    'series' => 4,
                    'repetitions' => '8-10',
                    'rest_seconds' => 90,
                ],
                [
                    'name' => 'Crucifixo na Máquina',
                    'series' => 3,
                    'repetitions' => '10-12',
                    'rest_seconds' => 60,
                ],
                [
                    'name' => 'Tríceps Pulley',
                    'series' => 3,
                    'repetitions' => '10-12',
                    'rest_seconds' => 60,
                ],
            ],
            'B' => [
                [
                    'name' => 'Puxada Frontal',
                    'series' => 4,
                    'repetitions' => '8-10',
                    'rest_seconds' => 90,
                ],
                [
                    'name' => 'Remada Curvada com Barra',
                    'series' => 3,
                    'repetitions' => '10-12',
                    'rest_seconds' => 75,
                ],
                [
                    'name' => 'Rosca Direta com Barra',
                    'series' => 3,
                    'repetitions' => '10-12',
                    'rest_seconds' => 60,
                ],
            ],
            'C' => [
                [
                    'name' => 'Agachamento Livre',
                    'series' => 4,
                    'repetitions' => '8-10',
                    'rest_seconds' => 120,
                ],
                [
                    'name' => 'Leg Press 45°',
                    'series' => 4,
                    'repetitions' => '10-12',
                    'rest_seconds' => 90,
                ],
                [
                    'name' => 'Panturrilha em Pé na Máquina',
                    'series' => 4,
                    'repetitions' => '12-15',
                    'rest_seconds' => 45,
                ],
            ],
        ];

        foreach ($students as $student) {
            DB::transaction(function () use ($student, $creatorId, $divisionIds, $exerciseIds, $divisionTemplate): void {
                $sheetName = 'Ficha Completa '.$student->code;

                $sheet = TrainingSheet::withTrashed()->updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'name' => $sheetName,
                    ],
                    [
                        'created_by' => $creatorId,
                        'updated_by' => $creatorId,
                        'start_date' => Carbon::now()->startOfMonth()->toDateString(),
                        'end_date' => Carbon::now()->addMonths(3)->endOfMonth()->toDateString(),
                        'is_active' => true,
                        'deleted_at' => null,
                    ]
                );

                $sheet->workoutLogs()->each(function (WorkoutLog $log): void {
                    $log->logExercises()->delete();
                    $log->delete();
                });

                $sheet->divisions()->with('exercises')->get()->each(function (TrainingSheetDivision $division): void {
                    $division->exercises()->delete();
                    $division->delete();
                });

                $createdDivisions = [];

                foreach (['A', 'B', 'C'] as $divisionOrder => $divisionName) {
                    $trainingDivisionId = $divisionIds[$divisionName] ?? null;

                    if (! $trainingDivisionId) {
                        continue;
                    }

                    $sheetDivision = TrainingSheetDivision::query()->create([
                        'training_sheet_id' => $sheet->id,
                        'training_division_id' => $trainingDivisionId,
                        'order' => $divisionOrder + 1,
                    ]);

                    $createdDivisions[] = $sheetDivision;

                    foreach ($divisionTemplate[$divisionName] as $exerciseOrder => $exercise) {
                        $exerciseId = $exerciseIds[$exercise['name']] ?? null;

                        if (! $exerciseId) {
                            continue;
                        }

                        TrainingExercise::query()->create([
                            'training_sheet_division_id' => $sheetDivision->id,
                            'exercise_id' => $exerciseId,
                            'series' => $exercise['series'],
                            'repetitions' => $exercise['repetitions'],
                            'rest_seconds' => $exercise['rest_seconds'],
                            'load' => null,
                            'observation' => null,
                            'order' => $exerciseOrder + 1,
                        ]);
                    }
                }

                foreach (array_slice($createdDivisions, 0, 2) as $index => $sheetDivision) {
                    $startedAt = Carbon::now()->subDays(7 - $index * 2)->setTime(18, 0);
                    $finishedAt = (clone $startedAt)->addMinutes(55);

                    $log = WorkoutLog::query()->create([
                        'student_id' => $student->id,
                        'training_sheet_id' => $sheet->id,
                        'training_sheet_division_id' => $sheetDivision->id,
                        'validated_by' => $creatorId,
                        'started_at' => $startedAt,
                        'finished_at' => $finishedAt,
                        'duration_minutes' => 55,
                    ]);

                    $sheetDivision->exercises()->orderBy('order')->get()->each(function (TrainingExercise $exercise) use ($log): void {
                        WorkoutLogExercise::query()->create([
                            'workout_log_id' => $log->id,
                            'exercise_id' => $exercise->exercise_id,
                            'performed_series' => $exercise->series,
                            'performed_repetitions' => $exercise->repetitions,
                            'performed_load' => null,
                            'completed' => true,
                            'observation' => null,
                        ]);
                    });
                }
            });
        }
    }
}
