<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Configurações gerais
            ConfigurationSeeder::class,

            // Controle de acesso
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,

            // Configurações — treino
            TrainingDivisionSeeder::class,
            MuscleGroupSeeder::class,
            EquipmentTypeSeeder::class,

            // Configurações — avaliação
            MeasurementTypeSeeder::class,

            // Configurações — nutrição
            FoodTypeSeeder::class,
            MealTypeSeeder::class,
            FoodSeeder::class,

            // Configurações — financeiro
            PlanTypeSeeder::class,
            PaymentTypeSeeder::class,
            ExpenseTypeSeeder::class,
            ItemTypeSeeder::class,
            FieldTypeSeeder::class,
            ItemSeeder::class,

            // Treino
            ExerciseSeeder::class,

            // Gestão
            StudentSeeder::class,

            // Fichas
            TrainingSheetSeeder::class,
            TrainingPlanTemplateSeeder::class,
            MealPlanTemplateSeeder::class,

            // Agendamentos
            BookingTypeSeeder::class,

            // Postagens
            PostTypeSeeder::class,
            PostSeeder::class,
        ]);
    }
}
