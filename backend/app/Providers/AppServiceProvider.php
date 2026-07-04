<?php

namespace App\Providers;

use App\Models\Assessment;
use App\Models\Booking;
use App\Models\BookingStudent;
use App\Models\BookingType;
use App\Models\Configuration;
use App\Models\CustomerRegistration;
use App\Models\EquipmentType;
use App\Models\Exercise;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\FieldType;
use App\Models\Food;
use App\Models\FoodType;
use App\Models\Item;
use App\Models\ItemFieldType;
use App\Models\ItemType;
use App\Models\MealPlan;
use App\Models\MealPlanFood;
use App\Models\MealPlanMeal;
use App\Models\MealType;
use App\Models\MeasurementType;
use App\Models\MonthlyFee;
use App\Models\MuscleGroup;
use App\Models\PaymentType;
use App\Models\Permission;
use App\Models\PlanType;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Role;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Student;
use App\Models\TrainingDivision;
use App\Models\TrainingExercise;
use App\Models\TrainingSheet;
use App\Models\TrainingSheetDivision;
use App\Models\User;
use App\Models\WorkoutLog;
use App\Models\WorkoutLogExercise;
use App\Observers\CustomerRegistrationObserver;
use App\Observers\MonthlyFeeObserver;
use App\Observers\StudentObserver;
use App\Policies\AssessmentPolicy;
use App\Policies\BookingPolicy;
use App\Policies\BookingStudentPolicy;
use App\Policies\BookingTypePolicy;
use App\Policies\ConfigurationPolicy;
use App\Policies\CustomerRegistrationPolicy;
use App\Policies\EquipmentTypePolicy;
use App\Policies\ExercisePolicy;
use App\Policies\ExpensePolicy;
use App\Policies\ExpenseTypePolicy;
use App\Policies\FieldTypePolicy;
use App\Policies\FoodPolicy;
use App\Policies\FoodTypePolicy;
use App\Policies\ItemFieldTypePolicy;
use App\Policies\ItemPolicy;
use App\Policies\ItemTypePolicy;
use App\Policies\MealPlanFoodPolicy;
use App\Policies\MealPlanMealPolicy;
use App\Policies\MealPlanPolicy;
use App\Policies\MealTypePolicy;
use App\Policies\MeasurementTypePolicy;
use App\Policies\MonthlyFeePolicy;
use App\Policies\MuscleGroupPolicy;
use App\Policies\PaymentTypePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PlanTypePolicy;
use App\Policies\PostPolicy;
use App\Policies\PostTypePolicy;
use App\Policies\RolePolicy;
use App\Policies\SaleItemPolicy;
use App\Policies\SalePolicy;
use App\Policies\StudentPolicy;
use App\Policies\TrainingDivisionPolicy;
use App\Policies\TrainingExercisePolicy;
use App\Policies\TrainingSheetDivisionPolicy;
use App\Policies\TrainingSheetPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkoutLogExercisePolicy;
use App\Policies\WorkoutLogPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends AuthServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Assessment::class => AssessmentPolicy::class,
        Booking::class => BookingPolicy::class,
        BookingStudent::class => BookingStudentPolicy::class,
        BookingType::class => BookingTypePolicy::class,
        Configuration::class => ConfigurationPolicy::class,
        CustomerRegistration::class => CustomerRegistrationPolicy::class,
        EquipmentType::class => EquipmentTypePolicy::class,
        Exercise::class => ExercisePolicy::class,
        Expense::class => ExpensePolicy::class,
        ExpenseType::class => ExpenseTypePolicy::class,
        FieldType::class => FieldTypePolicy::class,
        Food::class => FoodPolicy::class,
        FoodType::class => FoodTypePolicy::class,
        Item::class => ItemPolicy::class,
        ItemFieldType::class => ItemFieldTypePolicy::class,
        ItemType::class => ItemTypePolicy::class,
        MealPlan::class => MealPlanPolicy::class,
        MealPlanFood::class => MealPlanFoodPolicy::class,
        MealPlanMeal::class => MealPlanMealPolicy::class,
        MealType::class => MealTypePolicy::class,
        MeasurementType::class => MeasurementTypePolicy::class,
        MonthlyFee::class => MonthlyFeePolicy::class,
        MuscleGroup::class => MuscleGroupPolicy::class,
        PaymentType::class => PaymentTypePolicy::class,
        Permission::class => PermissionPolicy::class,
        PlanType::class => PlanTypePolicy::class,
        Post::class => PostPolicy::class,
        PostType::class => PostTypePolicy::class,
        Role::class => RolePolicy::class,
        Sale::class => SalePolicy::class,
        SaleItem::class => SaleItemPolicy::class,
        Student::class => StudentPolicy::class,
        TrainingDivision::class => TrainingDivisionPolicy::class,
        TrainingExercise::class => TrainingExercisePolicy::class,
        TrainingSheet::class => TrainingSheetPolicy::class,
        TrainingSheetDivision::class => TrainingSheetDivisionPolicy::class,
        User::class => UserPolicy::class,
        WorkoutLog::class => WorkoutLogPolicy::class,
        WorkoutLogExercise::class => WorkoutLogExercisePolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        $this->registerPolicies();

        Student::observe(StudentObserver::class);
        MonthlyFee::observe(MonthlyFeeObserver::class);
        CustomerRegistration::observe(CustomerRegistrationObserver::class);

        View::composer(['mail::*', 'vendor.mail.*'], function ($view) {
            $view->with('configuration', Configuration::first());
        });
    }
}
