<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Users
            ['name' => 'Ver Usuários',     'code' => 'user.view',   'group' => 'Usuários'],
            ['name' => 'Editar Usuários',  'code' => 'user.edit',   'group' => 'Usuários'],
            ['name' => 'Atualizar Usuários', 'code' => 'user.update', 'group' => 'Usuários'],
            ['name' => 'Deletar Usuários', 'code' => 'user.delete', 'group' => 'Usuários'],

            // Permissions
            ['name' => 'Ver Permissões',      'code' => 'permission.view',   'group' => 'Permissões'],
            ['name' => 'Criar Permissões',    'code' => 'permission.create', 'group' => 'Permissões'],
            ['name' => 'Editar Permissões',   'code' => 'permission.edit',   'group' => 'Permissões'],
            ['name' => 'Atualizar Permissões', 'code' => 'permission.update', 'group' => 'Permissões'],
            ['name' => 'Deletar Permissões',  'code' => 'permission.delete', 'group' => 'Permissões'],

            // Roles
            ['name' => 'Ver Perfis',      'code' => 'role.view',   'group' => 'Perfis'],
            ['name' => 'Criar Perfis',    'code' => 'role.create', 'group' => 'Perfis'],
            ['name' => 'Editar Perfis',   'code' => 'role.edit',   'group' => 'Perfis'],
            ['name' => 'Atualizar Perfis', 'code' => 'role.update', 'group' => 'Perfis'],
            ['name' => 'Deletar Perfis',  'code' => 'role.delete', 'group' => 'Perfis'],

            // Training Divisions
            ['name' => 'Ver Divisões de Treino',     'code' => 'training_division.view',   'group' => 'Divisões de Treino'],
            ['name' => 'Criar Divisões de Treino',   'code' => 'training_division.create', 'group' => 'Divisões de Treino'],
            ['name' => 'Editar Divisões de Treino',  'code' => 'training_division.edit',   'group' => 'Divisões de Treino'],
            ['name' => 'Atualizar Divisões de Treino', 'code' => 'training_division.update', 'group' => 'Divisões de Treino'],
            ['name' => 'Deletar Divisões de Treino', 'code' => 'training_division.delete', 'group' => 'Divisões de Treino'],

            // Muscle Groups
            ['name' => 'Ver Grupos Musculares',     'code' => 'muscle_group.view',   'group' => 'Grupos Musculares'],
            ['name' => 'Criar Grupos Musculares',   'code' => 'muscle_group.create', 'group' => 'Grupos Musculares'],
            ['name' => 'Editar Grupos Musculares',  'code' => 'muscle_group.edit',   'group' => 'Grupos Musculares'],
            ['name' => 'Atualizar Grupos Musculares', 'code' => 'muscle_group.update', 'group' => 'Grupos Musculares'],
            ['name' => 'Deletar Grupos Musculares', 'code' => 'muscle_group.delete', 'group' => 'Grupos Musculares'],

            // Measurement Types
            ['name' => 'Ver Tipos de Medição',     'code' => 'measurement_type.view',   'group' => 'Tipos de Medição'],
            ['name' => 'Criar Tipos de Medição',   'code' => 'measurement_type.create', 'group' => 'Tipos de Medição'],
            ['name' => 'Editar Tipos de Medição',  'code' => 'measurement_type.edit',   'group' => 'Tipos de Medição'],
            ['name' => 'Atualizar Tipos de Medição', 'code' => 'measurement_type.update', 'group' => 'Tipos de Medição'],
            ['name' => 'Deletar Tipos de Medição', 'code' => 'measurement_type.delete', 'group' => 'Tipos de Medição'],

            // Payment Types
            ['name' => 'Ver Tipos de Pagamento',     'code' => 'payment_type.view',   'group' => 'Tipos de Pagamento'],
            ['name' => 'Criar Tipos de Pagamento',   'code' => 'payment_type.create', 'group' => 'Tipos de Pagamento'],
            ['name' => 'Editar Tipos de Pagamento',  'code' => 'payment_type.edit',   'group' => 'Tipos de Pagamento'],
            ['name' => 'Atualizar Tipos de Pagamento', 'code' => 'payment_type.update', 'group' => 'Tipos de Pagamento'],
            ['name' => 'Deletar Tipos de Pagamento', 'code' => 'payment_type.delete', 'group' => 'Tipos de Pagamento'],

            // Equipment Types
            ['name' => 'Ver Tipos de Equipamento',     'code' => 'equipment_type.view',   'group' => 'Tipos de Equipamento'],
            ['name' => 'Criar Tipos de Equipamento',   'code' => 'equipment_type.create', 'group' => 'Tipos de Equipamento'],
            ['name' => 'Editar Tipos de Equipamento',  'code' => 'equipment_type.edit',   'group' => 'Tipos de Equipamento'],
            ['name' => 'Atualizar Tipos de Equipamento', 'code' => 'equipment_type.update', 'group' => 'Tipos de Equipamento'],
            ['name' => 'Deletar Tipos de Equipamento', 'code' => 'equipment_type.delete', 'group' => 'Tipos de Equipamento'],

            // Plan Types
            ['name' => 'Ver Tipos de Plano',     'code' => 'plan_type.view',   'group' => 'Tipos de Plano'],
            ['name' => 'Criar Tipos de Plano',   'code' => 'plan_type.create', 'group' => 'Tipos de Plano'],
            ['name' => 'Editar Tipos de Plano',  'code' => 'plan_type.edit',   'group' => 'Tipos de Plano'],
            ['name' => 'Atualizar Tipos de Plano', 'code' => 'plan_type.update', 'group' => 'Tipos de Plano'],
            ['name' => 'Deletar Tipos de Plano', 'code' => 'plan_type.delete', 'group' => 'Tipos de Plano'],

            // Food Types
            ['name' => 'Ver Tipos de Alimentos',     'code' => 'food_type.view',   'group' => 'Tipos de Alimentos'],
            ['name' => 'Criar Tipos de Alimentos',   'code' => 'food_type.create', 'group' => 'Tipos de Alimentos'],
            ['name' => 'Editar Tipos de Alimentos',  'code' => 'food_type.edit',   'group' => 'Tipos de Alimentos'],
            ['name' => 'Atualizar Tipos de Alimentos', 'code' => 'food_type.update', 'group' => 'Tipos de Alimentos'],
            ['name' => 'Deletar Tipos de Alimentos', 'code' => 'food_type.delete', 'group' => 'Tipos de Alimentos'],

            // Item Types
            ['name' => 'Ver Tipos de Itens',     'code' => 'item_type.view',   'group' => 'Tipos de Itens'],
            ['name' => 'Criar Tipos de Itens',   'code' => 'item_type.create', 'group' => 'Tipos de Itens'],
            ['name' => 'Editar Tipos de Itens',  'code' => 'item_type.edit',   'group' => 'Tipos de Itens'],
            ['name' => 'Atualizar Tipos de Itens', 'code' => 'item_type.update', 'group' => 'Tipos de Itens'],
            ['name' => 'Deletar Tipos de Itens', 'code' => 'item_type.delete', 'group' => 'Tipos de Itens'],

            // Meal Types
            ['name' => 'Ver Tipos de Refeição',     'code' => 'meal_type.view',   'group' => 'Tipos de Refeição'],
            ['name' => 'Criar Tipos de Refeição',   'code' => 'meal_type.create', 'group' => 'Tipos de Refeição'],
            ['name' => 'Editar Tipos de Refeição',  'code' => 'meal_type.edit',   'group' => 'Tipos de Refeição'],
            ['name' => 'Atualizar Tipos de Refeição', 'code' => 'meal_type.update', 'group' => 'Tipos de Refeição'],
            ['name' => 'Deletar Tipos de Refeição', 'code' => 'meal_type.delete', 'group' => 'Tipos de Refeição'],

            // Expense Types
            ['name' => 'Ver Tipos de Despesa',     'code' => 'expense_type.view',   'group' => 'Tipos de Despesa'],
            ['name' => 'Criar Tipos de Despesa',   'code' => 'expense_type.create', 'group' => 'Tipos de Despesa'],
            ['name' => 'Editar Tipos de Despesa',  'code' => 'expense_type.edit',   'group' => 'Tipos de Despesa'],
            ['name' => 'Atualizar Tipos de Despesa', 'code' => 'expense_type.update', 'group' => 'Tipos de Despesa'],
            ['name' => 'Deletar Tipos de Despesa', 'code' => 'expense_type.delete', 'group' => 'Tipos de Despesa'],

            // Exercises
            ['name' => 'Ver Exercícios',     'code' => 'exercise.view',   'group' => 'Exercícios'],
            ['name' => 'Criar Exercícios',   'code' => 'exercise.create', 'group' => 'Exercícios'],
            ['name' => 'Editar Exercícios',  'code' => 'exercise.edit',   'group' => 'Exercícios'],
            ['name' => 'Atualizar Exercícios', 'code' => 'exercise.update', 'group' => 'Exercícios'],
            ['name' => 'Deletar Exercícios', 'code' => 'exercise.delete', 'group' => 'Exercícios'],

            // Students
            ['name' => 'Ver Alunos',     'code' => 'student.view',   'group' => 'Alunos'],
            ['name' => 'Criar Alunos',   'code' => 'student.create', 'group' => 'Alunos'],
            ['name' => 'Editar Alunos',  'code' => 'student.edit',   'group' => 'Alunos'],
            ['name' => 'Atualizar Alunos', 'code' => 'student.update', 'group' => 'Alunos'],
            ['name' => 'Deletar Alunos', 'code' => 'student.delete', 'group' => 'Alunos'],

            // Training Sheets
            ['name' => 'Ver Fichas de Treino',     'code' => 'training_sheet.view',   'group' => 'Fichas de Treino'],
            ['name' => 'Criar Fichas de Treino',   'code' => 'training_sheet.create', 'group' => 'Fichas de Treino'],
            ['name' => 'Editar Fichas de Treino',  'code' => 'training_sheet.edit',   'group' => 'Fichas de Treino'],
            ['name' => 'Atualizar Fichas de Treino', 'code' => 'training_sheet.update', 'group' => 'Fichas de Treino'],
            ['name' => 'Deletar Fichas de Treino', 'code' => 'training_sheet.delete', 'group' => 'Fichas de Treino'],

            // Training Sheet Divisions
            ['name' => 'Ver Divisões de Ficha de Treino',     'code' => 'training_sheet_division.view',   'group' => 'Divisões de Ficha de Treino'],
            ['name' => 'Criar Divisões de Ficha de Treino',   'code' => 'training_sheet_division.create', 'group' => 'Divisões de Ficha de Treino'],
            ['name' => 'Editar Divisões de Ficha de Treino',  'code' => 'training_sheet_division.edit',   'group' => 'Divisões de Ficha de Treino'],
            ['name' => 'Atualizar Divisões de Ficha de Treino', 'code' => 'training_sheet_division.update', 'group' => 'Divisões de Ficha de Treino'],
            ['name' => 'Deletar Divisões de Ficha de Treino', 'code' => 'training_sheet_division.delete', 'group' => 'Divisões de Ficha de Treino'],

            // Training Exercises
            ['name' => 'Ver Exercícios de Treino',     'code' => 'training_exercise.view',   'group' => 'Exercícios de Treino'],
            ['name' => 'Criar Exercícios de Treino',   'code' => 'training_exercise.create', 'group' => 'Exercícios de Treino'],
            ['name' => 'Editar Exercícios de Treino',  'code' => 'training_exercise.edit',   'group' => 'Exercícios de Treino'],
            ['name' => 'Atualizar Exercícios de Treino', 'code' => 'training_exercise.update', 'group' => 'Exercícios de Treino'],
            ['name' => 'Deletar Exercícios de Treino', 'code' => 'training_exercise.delete', 'group' => 'Exercícios de Treino'],

            // Workout Logs
            ['name' => 'Ver Registros de Treino',     'code' => 'workout_log.view',   'group' => 'Registros de Treino'],
            ['name' => 'Criar Registros de Treino',   'code' => 'workout_log.create', 'group' => 'Registros de Treino'],
            ['name' => 'Editar Registros de Treino',  'code' => 'workout_log.edit',   'group' => 'Registros de Treino'],
            ['name' => 'Atualizar Registros de Treino', 'code' => 'workout_log.update', 'group' => 'Registros de Treino'],
            ['name' => 'Deletar Registros de Treino', 'code' => 'workout_log.delete', 'group' => 'Registros de Treino'],

            // Workout Log Exercises
            ['name' => 'Ver Exercícios de Registro de Treino',     'code' => 'workout_log_exercise.view',   'group' => 'Exercícios de Registro de Treino'],
            ['name' => 'Criar Exercícios de Registro de Treino',   'code' => 'workout_log_exercise.create', 'group' => 'Exercícios de Registro de Treino'],
            ['name' => 'Editar Exercícios de Registro de Treino',  'code' => 'workout_log_exercise.edit',   'group' => 'Exercícios de Registro de Treino'],
            ['name' => 'Atualizar Exercícios de Registro de Treino', 'code' => 'workout_log_exercise.update', 'group' => 'Exercícios de Registro de Treino'],
            ['name' => 'Deletar Exercícios de Registro de Treino', 'code' => 'workout_log_exercise.delete', 'group' => 'Exercícios de Registro de Treino'],

            // Post Types
            ['name' => 'Ver Tipos de Postagem',     'code' => 'post_type.view',   'group' => 'Tipos de Postagem'],
            ['name' => 'Criar Tipos de Postagem',   'code' => 'post_type.create', 'group' => 'Tipos de Postagem'],
            ['name' => 'Editar Tipos de Postagem',  'code' => 'post_type.edit',   'group' => 'Tipos de Postagem'],
            ['name' => 'Atualizar Tipos de Postagem', 'code' => 'post_type.update', 'group' => 'Tipos de Postagem'],
            ['name' => 'Deletar Tipos de Postagem', 'code' => 'post_type.delete', 'group' => 'Tipos de Postagem'],

            // Posts
            ['name' => 'Ver Postagens',     'code' => 'post.view',   'group' => 'Postagens'],
            ['name' => 'Criar Postagens',   'code' => 'post.create', 'group' => 'Postagens'],
            ['name' => 'Editar Postagens',  'code' => 'post.edit',   'group' => 'Postagens'],
            ['name' => 'Atualizar Postagens', 'code' => 'post.update', 'group' => 'Postagens'],
            ['name' => 'Deletar Postagens', 'code' => 'post.delete', 'group' => 'Postagens'],

            // Assessments
            ['name' => 'Ver Avaliações',     'code' => 'assessment.view',   'group' => 'Avaliações'],
            ['name' => 'Criar Avaliações',   'code' => 'assessment.create', 'group' => 'Avaliações'],
            ['name' => 'Editar Avaliações',  'code' => 'assessment.edit',   'group' => 'Avaliações'],
            ['name' => 'Atualizar Avaliações', 'code' => 'assessment.update', 'group' => 'Avaliações'],
            ['name' => 'Deletar Avaliações', 'code' => 'assessment.delete', 'group' => 'Avaliações'],

            // Foods
            ['name' => 'Ver Alimentos',     'code' => 'food.view',   'group' => 'Alimentos'],
            ['name' => 'Criar Alimentos',   'code' => 'food.create', 'group' => 'Alimentos'],
            ['name' => 'Editar Alimentos',  'code' => 'food.edit',   'group' => 'Alimentos'],
            ['name' => 'Atualizar Alimentos', 'code' => 'food.update', 'group' => 'Alimentos'],
            ['name' => 'Deletar Alimentos', 'code' => 'food.delete', 'group' => 'Alimentos'],

            // Meal Plans
            ['name' => 'Ver Planos de Refeição',     'code' => 'meal_plan.view',   'group' => 'Planos de Refeição'],
            ['name' => 'Criar Planos de Refeição',   'code' => 'meal_plan.create', 'group' => 'Planos de Refeição'],
            ['name' => 'Editar Planos de Refeição',  'code' => 'meal_plan.edit',   'group' => 'Planos de Refeição'],
            ['name' => 'Atualizar Planos de Refeição', 'code' => 'meal_plan.update', 'group' => 'Planos de Refeição'],
            ['name' => 'Deletar Planos de Refeição', 'code' => 'meal_plan.delete', 'group' => 'Planos de Refeição'],

            // Meal Plan Meals
            ['name' => 'Ver Refeições do Plano',     'code' => 'meal_plan_meal.view',   'group' => 'Refeições do Plano'],
            ['name' => 'Criar Refeições do Plano',   'code' => 'meal_plan_meal.create', 'group' => 'Refeições do Plano'],
            ['name' => 'Editar Refeições do Plano',  'code' => 'meal_plan_meal.edit',   'group' => 'Refeições do Plano'],
            ['name' => 'Atualizar Refeições do Plano', 'code' => 'meal_plan_meal.update', 'group' => 'Refeições do Plano'],
            ['name' => 'Deletar Refeições do Plano', 'code' => 'meal_plan_meal.delete', 'group' => 'Refeições do Plano'],

            // Meal Plan Foods
            ['name' => 'Ver Alimentos do Plano de Refeição',     'code' => 'meal_plan_food.view',   'group' => 'Alimentos do Plano de Refeição'],
            ['name' => 'Criar Alimentos do Plano de Refeição',   'code' => 'meal_plan_food.create', 'group' => 'Alimentos do Plano de Refeição'],
            ['name' => 'Editar Alimentos do Plano de Refeição',  'code' => 'meal_plan_food.edit',   'group' => 'Alimentos do Plano de Refeição'],
            ['name' => 'Atualizar Alimentos do Plano de Refeição', 'code' => 'meal_plan_food.update', 'group' => 'Alimentos do Plano de Refeição'],
            ['name' => 'Deletar Alimentos do Plano de Refeição', 'code' => 'meal_plan_food.delete', 'group' => 'Alimentos do Plano de Refeição'],

            // Monthly Fees
            ['name' => 'Ver Mensalidades',     'code' => 'monthly_fee.view',   'group' => 'Mensalidades'],
            ['name' => 'Criar Mensalidades',   'code' => 'monthly_fee.create', 'group' => 'Mensalidades'],
            ['name' => 'Editar Mensalidades',  'code' => 'monthly_fee.edit',   'group' => 'Mensalidades'],
            ['name' => 'Atualizar Mensalidades', 'code' => 'monthly_fee.update', 'group' => 'Mensalidades'],
            ['name' => 'Deletar Mensalidades', 'code' => 'monthly_fee.delete', 'group' => 'Mensalidades'],

            // Expenses
            ['name' => 'Ver Despesas',     'code' => 'expense.view',   'group' => 'Despesas'],
            ['name' => 'Criar Despesas',   'code' => 'expense.create', 'group' => 'Despesas'],
            ['name' => 'Editar Despesas',  'code' => 'expense.edit',   'group' => 'Despesas'],
            ['name' => 'Atualizar Despesas', 'code' => 'expense.update', 'group' => 'Despesas'],
            ['name' => 'Deletar Despesas', 'code' => 'expense.delete', 'group' => 'Despesas'],

            // Booking Types
            ['name' => 'Ver Tipos de Reserva',     'code' => 'booking_type.view',   'group' => 'Tipos de Reserva'],
            ['name' => 'Criar Tipos de Reserva',   'code' => 'booking_type.create', 'group' => 'Tipos de Reserva'],
            ['name' => 'Editar Tipos de Reserva',  'code' => 'booking_type.edit',   'group' => 'Tipos de Reserva'],
            ['name' => 'Atualizar Tipos de Reserva', 'code' => 'booking_type.update', 'group' => 'Tipos de Reserva'],
            ['name' => 'Deletar Tipos de Reserva', 'code' => 'booking_type.delete', 'group' => 'Tipos de Reserva'],

            // Bookings
            ['name' => 'Ver Reservas',     'code' => 'booking.view',   'group' => 'Reservas'],
            ['name' => 'Criar Reservas',   'code' => 'booking.create', 'group' => 'Reservas'],
            ['name' => 'Editar Reservas',  'code' => 'booking.edit',   'group' => 'Reservas'],
            ['name' => 'Atualizar Reservas', 'code' => 'booking.update', 'group' => 'Reservas'],
            ['name' => 'Deletar Reservas', 'code' => 'booking.delete', 'group' => 'Reservas'],

            // Booking Students
            ['name' => 'Ver Alunos de Reserva',     'code' => 'booking_student.view',   'group' => 'Alunos de Reserva'],
            ['name' => 'Criar Alunos de Reserva',   'code' => 'booking_student.create', 'group' => 'Alunos de Reserva'],
            ['name' => 'Editar Alunos de Reserva',  'code' => 'booking_student.edit',   'group' => 'Alunos de Reserva'],
            ['name' => 'Atualizar Alunos de Reserva', 'code' => 'booking_student.update', 'group' => 'Alunos de Reserva'],
            ['name' => 'Deletar Alunos de Reserva', 'code' => 'booking_student.delete', 'group' => 'Alunos de Reserva'],

            // Field Types
            ['name' => 'Ver Tipos de Campo',     'code' => 'field_type.view',   'group' => 'Tipos de Campo'],
            ['name' => 'Criar Tipos de Campo',   'code' => 'field_type.create', 'group' => 'Tipos de Campo'],
            ['name' => 'Editar Tipos de Campo',  'code' => 'field_type.edit',   'group' => 'Tipos de Campo'],
            ['name' => 'Atualizar Tipos de Campo', 'code' => 'field_type.update', 'group' => 'Tipos de Campo'],
            ['name' => 'Deletar Tipos de Campo', 'code' => 'field_type.delete', 'group' => 'Tipos de Campo'],

            // Items
            ['name' => 'Ver Itens',     'code' => 'item.view',   'group' => 'Itens'],
            ['name' => 'Criar Itens',   'code' => 'item.create', 'group' => 'Itens'],
            ['name' => 'Editar Itens',  'code' => 'item.edit',   'group' => 'Itens'],
            ['name' => 'Atualizar Itens', 'code' => 'item.update', 'group' => 'Itens'],
            ['name' => 'Deletar Itens', 'code' => 'item.delete', 'group' => 'Itens'],

            // Item Field Types
            ['name' => 'Ver Campos de Itens',     'code' => 'item_field_type.view',   'group' => 'Campos de Itens'],
            ['name' => 'Criar Campos de Itens',   'code' => 'item_field_type.create', 'group' => 'Campos de Itens'],
            ['name' => 'Editar Campos de Itens',  'code' => 'item_field_type.edit',   'group' => 'Campos de Itens'],
            ['name' => 'Atualizar Campos de Itens', 'code' => 'item_field_type.update', 'group' => 'Campos de Itens'],
            ['name' => 'Deletar Campos de Itens', 'code' => 'item_field_type.delete', 'group' => 'Campos de Itens'],

            // Sales
            ['name' => 'Ver Vendas',     'code' => 'sale.view',   'group' => 'Vendas'],
            ['name' => 'Criar Vendas',   'code' => 'sale.create', 'group' => 'Vendas'],
            ['name' => 'Editar Vendas',  'code' => 'sale.edit',   'group' => 'Vendas'],
            ['name' => 'Atualizar Vendas', 'code' => 'sale.update', 'group' => 'Vendas'],
            ['name' => 'Deletar Vendas', 'code' => 'sale.delete', 'group' => 'Vendas'],

            // Sale Items
            ['name' => 'Ver Itens de Venda',     'code' => 'sale_item.view',   'group' => 'Itens de Venda'],
            ['name' => 'Criar Itens de Venda',   'code' => 'sale_item.create', 'group' => 'Itens de Venda'],
            ['name' => 'Editar Itens de Venda',  'code' => 'sale_item.edit',   'group' => 'Itens de Venda'],
            ['name' => 'Atualizar Itens de Venda', 'code' => 'sale_item.update', 'group' => 'Itens de Venda'],
            ['name' => 'Deletar Itens de Venda', 'code' => 'sale_item.delete', 'group' => 'Itens de Venda'],

            // Configurations
            ['name' => 'Ver Configurações',     'code' => 'configuration.view',   'group' => 'Configurações'],
            ['name' => 'Criar Configurações',   'code' => 'configuration.create', 'group' => 'Configurações'],
            ['name' => 'Editar Configurações',  'code' => 'configuration.edit',   'group' => 'Configurações'],
            ['name' => 'Atualizar Configurações', 'code' => 'configuration.update', 'group' => 'Configurações'],
            ['name' => 'Deletar Configurações', 'code' => 'configuration.delete', 'group' => 'Configurações'],

            // Customer Registration
            ['name' => 'Ver Pré Registro',     'code' => 'customer_registration.view',   'group' => 'Pré Registro'],
            ['name' => 'Criar Pré Registro',   'code' => 'customer_registration.create', 'group' => 'Pré Registro'],
            ['name' => 'Editar Pré Registro',  'code' => 'customer_registration.edit',   'group' => 'Pré Registro'],
            ['name' => 'Atualizar Pré Registro', 'code' => 'customer_registration.update', 'group' => 'Pré Registro'],
            ['name' => 'Deletar Pré Registro', 'code' => 'customer_registration.delete', 'group' => 'Pré Registro'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['code' => $permission['code']],
                $permission
            );
        }
    }
}
