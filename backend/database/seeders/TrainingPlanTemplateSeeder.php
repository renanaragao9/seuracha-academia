<?php

namespace Database\Seeders;

use App\Models\TrainingPlanTemplate;
use Illuminate\Database\Seeder;

class TrainingPlanTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Hipertrofia Iniciante ABC',
                'description' => 'Plano de 3 dias por semana focado em ganho de massa muscular para iniciantes. Divisão ABC clássica com foco em aprender a execução correta.',
                'goal' => 'hipertrofia',
                'experience_level' => 'iniciante',
                'sessions_per_week' => 3,
                'template_data' => [
                    'warmup' => '5-10 min de cardio leve + mobilidade articular',
                    'cooldown' => '5-10 min de alongamento leve',
                    'divisions' => [
                        [
                            'training_division_name' => 'A',
                            'order' => 1,
                            'exercises' => [
                                ['exercise_name' => 'Supino Reto Barra', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 1, 'observation' => 'Foco na execução, carga moderada'],
                                ['exercise_name' => 'Crucifixo Máquina', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Supino 45° Máquina', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Elevação Lateral Halteres', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Tríceps Corda', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Abdominal (opcional)', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'B',
                            'order' => 2,
                            'exercises' => [
                                ['exercise_name' => 'Puxada Frontal', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 1, 'observation' => null],
                                ['exercise_name' => 'Remada Curvada', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 2, 'observation' => 'Cuidado com a postura da lombar'],
                                ['exercise_name' => 'Pull Down Polia', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Face Pull', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => 'Exercício de manguito rotador'],
                                ['exercise_name' => 'Rosca Direta Barra', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Rosca Martelo', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'C',
                            'order' => 3,
                            'exercises' => [
                                ['exercise_name' => 'Agachamento Livre', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 90, 'order' => 1, 'observation' => 'Priorize amplitude e técnica'],
                                ['exercise_name' => 'Leg Press', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Cadeira Extensora', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Cadeira Flexora', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Elevação Pélvica', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Panturrilha Máquina', 'series' => 4, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 6, 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Hipertrofia Intermediário ABCD',
                'description' => 'Plano de 4 dias por semana com divisão ABCD para hipertrofia intermediária. Maior volume e intensidade.',
                'goal' => 'hipertrofia',
                'experience_level' => 'intermediario',
                'sessions_per_week' => 4,
                'template_data' => [
                    'warmup' => '5-10 min de cardio leve + mobilidade articular',
                    'cooldown' => '5-10 min de alongamento leve',
                    'divisions' => [
                        [
                            'training_division_name' => 'A',
                            'order' => 1,
                            'exercises' => [
                                ['exercise_name' => 'Supino Reto Barra', 'series' => 4, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 1, 'observation' => 'Exercício principal de força'],
                                ['exercise_name' => 'Supino 45° Halteres', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Crucifixo Reto', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Crossover', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => 'Contrair bem o peito'],
                                ['exercise_name' => 'Tríceps Testa Barra', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Tríceps Corda', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'B',
                            'order' => 2,
                            'exercises' => [
                                ['exercise_name' => 'Agachamento Livre', 'series' => 4, 'repetitions' => '8-10', 'rest_seconds' => 120, 'order' => 1, 'observation' => 'Exercício principal de força'],
                                ['exercise_name' => 'Leg 45°', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 90, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Mesa Flexora', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Cadeira Extensora', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Elevação Pélvica', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Panturrilha na Barra', 'series' => 4, 'repetitions' => '12-15', 'rest_seconds' => 30, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'C',
                            'order' => 3,
                            'exercises' => [
                                ['exercise_name' => 'Puxada Frontal', 'series' => 4, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 1, 'observation' => null],
                                ['exercise_name' => 'Remada Curvada', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 75, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Remada Cavalinho', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Peck Deck Invertido', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Rosca Direta Barra', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 60, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Rosca Alternada', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'D',
                            'order' => 4,
                            'exercises' => [
                                ['exercise_name' => 'Desenvolvimento Barra', 'series' => 4, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 1, 'observation' => null],
                                ['exercise_name' => 'Elevação Lateral Halteres', 'series' => 4, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 2, 'observation' => 'Foco na contração do deltoide'],
                                ['exercise_name' => 'Elevação Frontal Halteres', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Encolhimento Halteres', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Arnold Press', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Face Pull', 'series' => 3, 'repetitions' => '15-15', 'rest_seconds' => 45, 'order' => 6, 'observation' => 'Saúde do manguito rotador'],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Hipertrofia Avançado ABCDE',
                'description' => 'Plano de 5 dias por semana para atletas avançados. Alto volume, divisão ABCDE com foco em hipertrofia máxima.',
                'goal' => 'hipertrofia',
                'experience_level' => 'avancado',
                'sessions_per_week' => 5,
                'template_data' => [
                    'warmup' => '5-10 min de cardio + mobilidade específica',
                    'cooldown' => '5-10 min de alongamento',
                    'divisions' => [
                        [
                            'training_division_name' => 'A',
                            'order' => 1,
                            'exercises' => [
                                ['exercise_name' => 'Supino Reto Barra', 'series' => 4, 'repetitions' => '6-8', 'rest_seconds' => 120, 'order' => 1, 'observation' => 'Progressão de carga a cada semana'],
                                ['exercise_name' => 'Supino Halteres', 'series' => 4, 'repetitions' => '8-10', 'rest_seconds' => 60, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Crucifixo Inclinado', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Crossover', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => 'Dropset na última série'],
                                ['exercise_name' => 'Peck Deck', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Abdominal (opcional)', 'series' => 4, 'repetitions' => '20-20', 'rest_seconds' => 30, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'B',
                            'order' => 2,
                            'exercises' => [
                                ['exercise_name' => 'Puxada Frontal', 'series' => 4, 'repetitions' => '6-8', 'rest_seconds' => 120, 'order' => 1, 'observation' => 'Progressão de carga'],
                                ['exercise_name' => 'Remada Curvada', 'series' => 4, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Pull Down Polia', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Remada Cavalinho', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Crucifixo Invertido', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Rosca Alternada', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'C',
                            'order' => 3,
                            'exercises' => [
                                ['exercise_name' => 'Agachamento Livre', 'series' => 5, 'repetitions' => '6-8', 'rest_seconds' => 120, 'order' => 1, 'observation' => 'Foco em progressão de carga'],
                                ['exercise_name' => 'Leg 45°', 'series' => 4, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Stiff', 'series' => 4, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 3, 'observation' => 'Cuidado com a lombar'],
                                ['exercise_name' => 'Cadeira Flexora', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Cadeira Extensora', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Panturrilha Máquina', 'series' => 4, 'repetitions' => '12-15', 'rest_seconds' => 30, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'D',
                            'order' => 4,
                            'exercises' => [
                                ['exercise_name' => 'Desenvolvimento Barra', 'series' => 4, 'repetitions' => '6-8', 'rest_seconds' => 120, 'order' => 1, 'observation' => null],
                                ['exercise_name' => 'Elevação Lateral Halteres', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Elevação Frontal Alternado', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Encolhimento Halteres', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 4, 'observation' => 'Segurar por 2s no topo'],
                                ['exercise_name' => 'Elevação Lateral Polia', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => 'Dropset na última'],
                                ['exercise_name' => 'Tríceps Barra', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'E',
                            'order' => 5,
                            'exercises' => [
                                ['exercise_name' => 'Barra Fixa', 'series' => 4, 'repetitions' => 'Máximo', 'rest_seconds' => 90, 'order' => 1, 'observation' => 'Com auxílio se necessário'],
                                ['exercise_name' => 'Rosca Scott Barra', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Rosca Martelo', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Tríceps Testa Barra', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Mergulho Banco', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Face Pull', 'series' => 3, 'repetitions' => '15-15', 'rest_seconds' => 45, 'order' => 6, 'observation' => 'Saúde do manguito'],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Emagrecimento Iniciante Full Body',
                'description' => 'Plano de 3 dias por semana focado em queima de gordura. Treino de corpo inteiro com exercícios multiarticulares para maximizar gasto calórico.',
                'goal' => 'emagrecimento',
                'experience_level' => 'iniciante',
                'sessions_per_week' => 3,
                'template_data' => [
                    'warmup' => '10 min de cardio moderado + mobilidade',
                    'cooldown' => '5-10 min de alongamento + cardio leve',
                    'divisions' => [
                        [
                            'training_division_name' => 'Full Body',
                            'order' => 1,
                            'exercises' => [
                                ['exercise_name' => 'Agachamento Livre', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 1, 'observation' => 'Foco em movimento completo, sem pressa'],
                                ['exercise_name' => 'Supino Reto Barra', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 2, 'observation' => 'Carga leve, foco na técnica'],
                                ['exercise_name' => 'Puxada Frontal', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Leg Press', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Remada Curvada', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Elevação Pélvica', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 6, 'observation' => null],
                                ['exercise_name' => 'Desenvolvimento Sentado', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 7, 'observation' => null],
                                ['exercise_name' => 'Rosca Direta Barra', 'series' => 2, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 8, 'observation' => null],
                                ['exercise_name' => 'Tríceps Corda', 'series' => 2, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 9, 'observation' => null],
                                ['exercise_name' => 'Abdominal (opcional)', 'series' => 3, 'repetitions' => '20-20', 'rest_seconds' => 30, 'order' => 10, 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Emagrecimento Intermediário Upper/Lower',
                'description' => 'Plano de 4 dias por semana com divisão Superior/Inferior. Ideal para queima de gordura com manutenção de massa muscular.',
                'goal' => 'emagrecimento',
                'experience_level' => 'intermediario',
                'sessions_per_week' => 4,
                'template_data' => [
                    'warmup' => '10 min de cardio moderado + mobilidade',
                    'cooldown' => 'Cardio leve 10-15 min + alongamento',
                    'divisions' => [
                        [
                            'training_division_name' => 'Upper',
                            'order' => 1,
                            'exercises' => [
                                ['exercise_name' => 'Supino Reto Barra', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 1, 'observation' => '2s excêntrica, 1s concêntrica'],
                                ['exercise_name' => 'Puxada Frontal', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Desenvolvimento Sentado', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Remada Curvada', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Crucifixo Máquina', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Elevação Lateral Halteres', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 6, 'observation' => null],
                                ['exercise_name' => 'Rosca Direta Halteres', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 7, 'observation' => null],
                                ['exercise_name' => 'Tríceps Corda', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 8, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'Lower',
                            'order' => 2,
                            'exercises' => [
                                ['exercise_name' => 'Agachamento Livre', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 1, 'observation' => 'Foco em amplitude total'],
                                ['exercise_name' => 'Stiff', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 2, 'observation' => 'Sentir bem o posterior'],
                                ['exercise_name' => 'Leg 45°', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Mesa Flexora', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Elevação Pélvica', 'series' => 4, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => 'Contrair glúteo no topo'],
                                ['exercise_name' => 'Cadeira Extensora', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 6, 'observation' => null],
                                ['exercise_name' => 'Panturrilha Máquina', 'series' => 4, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 7, 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Força — Powerlifting',
                'description' => 'Plano de 3-4 dias focado nos 3 grandes levantamentos: supino, agachamento e levantamento terra. Ideal para ganho de força máxima.',
                'goal' => 'forca',
                'experience_level' => 'intermediario',
                'sessions_per_week' => 4,
                'template_data' => [
                    'warmup' => '10-15 min de mobilidade + séries de aquecimento progressivas',
                    'cooldown' => '5-10 min de alongamento',
                    'divisions' => [
                        [
                            'training_division_name' => 'A',
                            'order' => 1,
                            'exercises' => [
                                ['exercise_name' => 'Agachamento Livre', 'series' => 5, 'repetitions' => '5', 'rest_seconds' => 180, 'order' => 1, 'observation' => 'Exercício principal — foco em progressão de carga'],
                                ['exercise_name' => 'Leg Press', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 2, 'observation' => 'Assistência'],
                                ['exercise_name' => 'Cadeira Flexora', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 60, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Elevação Pélvica', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Panturrilha na Barra', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Abdominal (opcional)', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 6, 'observation' => 'Fortalecimento do core'],
                            ],
                        ],
                        [
                            'training_division_name' => 'B',
                            'order' => 2,
                            'exercises' => [
                                ['exercise_name' => 'Supino Reto Barra', 'series' => 5, 'repetitions' => '5', 'rest_seconds' => 180, 'order' => 1, 'observation' => 'Exercício principal — foco em progressão de carga'],
                                ['exercise_name' => 'Supino Halteres', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 2, 'observation' => 'Assistência'],
                                ['exercise_name' => 'Desenvolvimento Barra', 'series' => 3, 'repetitions' => '6-8', 'rest_seconds' => 90, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Tríceps Testa Barra', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 60, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Elevação Lateral Halteres', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Face Pull', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 6, 'observation' => 'Saúde do manguito'],
                            ],
                        ],
                        [
                            'training_division_name' => 'C',
                            'order' => 3,
                            'exercises' => [
                                ['exercise_name' => 'Stiff', 'series' => 4, 'repetitions' => '5', 'rest_seconds' => 180, 'order' => 1, 'observation' => 'Levantamento terra stiff — foco em força'],
                                ['exercise_name' => 'Puxada Frontal', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 2, 'observation' => 'Assistência'],
                                ['exercise_name' => 'Remada Curvada', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Rosca Direta Barra', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 60, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Encolhimento Halteres', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Abdominal (opcional)', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 6, 'observation' => 'Fortalecimento do core'],
                            ],
                        ],
                        [
                            'training_division_name' => 'D',
                            'order' => 4,
                            'exercises' => [
                                ['exercise_name' => 'Agachamento Livre', 'series' => 4, 'repetitions' => '6-8', 'rest_seconds' => 120, 'order' => 1, 'observation' => 'Variação de intensidade — técnica e velocidade'],
                                ['exercise_name' => 'Supino Pegada Fechada', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 2, 'observation' => 'Força de tríceps no supino'],
                                ['exercise_name' => 'Cadeira Extensora', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Rosca Martelo', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Mergulho Paralela', 'series' => 3, 'repetitions' => '8-10', 'rest_seconds' => 90, 'order' => 5, 'observation' => 'Com peso extra se possível'],
                                ['exercise_name' => 'Panturrilha Máquina', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 6, 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Glúteos e Inferiores',
                'description' => 'Plano de 4 dias focado em glúteos e membros inferiores. Ideal para quem quer desenvolver pernas e glúteos com definição superior.',
                'goal' => 'gluteo',
                'experience_level' => 'intermediario',
                'sessions_per_week' => 4,
                'template_data' => [
                    'warmup' => '10 min de mobilidade de quadril + ativação de glúteos',
                    'cooldown' => 'Alongamento focado em quadris e posteriores',
                    'divisions' => [
                        [
                            'training_division_name' => 'A',
                            'order' => 1,
                            'exercises' => [
                                ['exercise_name' => 'Elevação Pélvica', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 1, 'observation' => 'Foco na contração do glúteo, segurar 2s no topo'],
                                ['exercise_name' => 'Agachamento Livre', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 90, 'order' => 2, 'observation' => 'Descer bem devagar'],
                                ['exercise_name' => 'Avanço', 'series' => 3, 'repetitions' => '10', 'rest_seconds' => 60, 'order' => 3, 'observation' => '10 cada perna'],
                                ['exercise_name' => 'Abdução de Quadril', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 4, 'observation' => 'Sentir glúteo médio'],
                                ['exercise_name' => 'Panturrilha Máquina', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 5, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'B',
                            'order' => 2,
                            'exercises' => [
                                ['exercise_name' => 'Puxada Frontal', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 1, 'observation' => null],
                                ['exercise_name' => 'Remada Curvada', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Desenvolvimento Sentado', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Supino Halteres', 'series' => 3, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Tríceps Corda', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Rosca Alternada', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 6, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'C',
                            'order' => 3,
                            'exercises' => [
                                ['exercise_name' => 'Stiff', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 75, 'order' => 1, 'observation' => 'Alongar bem o posterior'],
                                ['exercise_name' => 'Sumô', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 60, 'order' => 2, 'observation' => 'Abertura ampla, foco em glúteos e adutores'],
                                ['exercise_name' => 'Extensão de Quadril', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 3, 'observation' => 'Coice no cabo'],
                                ['exercise_name' => 'Cadeira Flexora', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Panturrilha na Barra', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 30, 'order' => 5, 'observation' => null],
                            ],
                        ],
                        [
                            'training_division_name' => 'D',
                            'order' => 4,
                            'exercises' => [
                                ['exercise_name' => 'Leg 45°', 'series' => 4, 'repetitions' => '10-12', 'rest_seconds' => 90, 'order' => 1, 'observation' => 'Pés altos para foco em glúteos'],
                                ['exercise_name' => 'Agachamento Afundo', 'series' => 3, 'repetitions' => '10', 'rest_seconds' => 60, 'order' => 2, 'observation' => '10 cada perna'],
                                ['exercise_name' => 'Elevação Pélvica', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 3, 'observation' => 'Unilateral na última série'],
                                ['exercise_name' => 'Cadeira Extensora', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 45, 'order' => 4, 'observation' => null],
                                ['exercise_name' => 'Abdução de Quadril', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Panturrilha Máquina', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 6, 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Condicionamento Full Body',
                'description' => 'Plano de 3 dias por semana focado em condicionamento físico geral. Circuito com exercícios multiarticulares, ideal para melhorar resistência e saúde cardiovascular.',
                'goal' => 'condicionamento',
                'experience_level' => 'todos',
                'sessions_per_week' => 3,
                'template_data' => [
                    'warmup' => '10 min de cardio + mobilidade dinâmica',
                    'cooldown' => '10 min de cardio leve + alongamento',
                    'divisions' => [
                        [
                            'training_division_name' => 'Full Body',
                            'order' => 1,
                            'exercises' => [
                                ['exercise_name' => 'Agachamento Livre', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 1, 'observation' => 'Execução rápida e controlada'],
                                ['exercise_name' => 'Supino Halteres', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 30, 'order' => 2, 'observation' => null],
                                ['exercise_name' => 'Remada Curvada', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 30, 'order' => 3, 'observation' => null],
                                ['exercise_name' => 'Passada', 'series' => 3, 'repetitions' => '12', 'rest_seconds' => 30, 'order' => 4, 'observation' => '12 cada perna'],
                                ['exercise_name' => 'Desenvolvimento Sentado', 'series' => 3, 'repetitions' => '12-15', 'rest_seconds' => 30, 'order' => 5, 'observation' => null],
                                ['exercise_name' => 'Rosca Martelo Alternada', 'series' => 2, 'repetitions' => '12-15', 'rest_seconds' => 30, 'order' => 6, 'observation' => null],
                                ['exercise_name' => 'Tríceps Coice', 'series' => 2, 'repetitions' => '12-15', 'rest_seconds' => 30, 'order' => 7, 'observation' => null],
                                ['exercise_name' => 'Elevação Pélvica', 'series' => 3, 'repetitions' => '15-20', 'rest_seconds' => 30, 'order' => 8, 'observation' => null],
                                ['exercise_name' => 'Abdominal (opcional)', 'series' => 3, 'repetitions' => '20-20', 'rest_seconds' => 30, 'order' => 9, 'observation' => null],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($templates as $template) {
            TrainingPlanTemplate::updateOrCreate(
                [
                    'name' => $template['name'],
                    'goal' => $template['goal'],
                    'experience_level' => $template['experience_level'],
                ],
                [
                    'description' => $template['description'],
                    'sessions_per_week' => $template['sessions_per_week'],
                    'template_data' => $template['template_data'],
                    'is_active' => true,
                ]
            );
        }
    }
}
