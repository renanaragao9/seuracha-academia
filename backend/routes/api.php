<?php

use App\Http\Controllers\Api\V1\AssessmentController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\ConfigurationController;
use App\Http\Controllers\Api\V1\CustomerRegistrationController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\ItemTypeController;
use App\Http\Controllers\Api\V1\LandingController;
use App\Http\Controllers\Api\V1\IAController;
use App\Http\Controllers\Api\V1\MealPlanController;
use App\Http\Controllers\Api\V1\MonthlyFeeController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\PurchaseController;
use App\Http\Controllers\Api\V1\StudentController;
use App\Http\Controllers\Api\V1\TrainingSheetController;
use App\Http\Controllers\Api\V1\WorkoutLogController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::get('configuration', [ConfigurationController::class, 'show'])->name('configuration.show');
    Route::get('landing', [LandingController::class, 'index'])->name('landing.index');
    Route::post('customer_registrations', [CustomerRegistrationController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::prefix('students')->name('students.')->group(function () {
            Route::post('show', [StudentController::class, 'show'])->name('show');
        });

        Route::get('profile', [StudentController::class, 'profile'])->name('profile');
        Route::post('profile/image', [StudentController::class, 'updateProfileImage'])->name('profile.image');
        Route::put('password', [StudentController::class, 'changePassword'])->name('password.change');

        Route::prefix('training_sheets')->name('training_sheets.')->group(function () {
            Route::get('/', [TrainingSheetController::class, 'index'])->name('index');
            Route::get('{training_sheet}', [TrainingSheetController::class, 'show'])->name('show');
            Route::get('{training_sheet}/pdf', [TrainingSheetController::class, 'downloadPdf'])->name('pdf');
        });

        Route::prefix('assessments')->name('assessments.')->group(function () {
            Route::get('/', [AssessmentController::class, 'index'])->name('index');
            Route::get('{assessment}', [AssessmentController::class, 'show'])->name('show');
            Route::get('{assessment}/pdf', [AssessmentController::class, 'downloadPdf'])->name('pdf');
        });

        Route::prefix('meal_plans')->name('meal_plans.')->group(function () {
            Route::get('/', [MealPlanController::class, 'index'])->name('index');
            Route::get('{meal_plan}', [MealPlanController::class, 'show'])->name('show');
            Route::get('{meal_plan}/pdf', [MealPlanController::class, 'downloadPdf'])->name('pdf');
        });

        Route::prefix('monthly_fees')->name('monthly_fees.')->group(function () {
            Route::get('/', [MonthlyFeeController::class, 'index'])->name('index');
            Route::get('{monthly_fee}', [MonthlyFeeController::class, 'show'])->name('show');
            Route::get('{monthly_fee}/pdf', [MonthlyFeeController::class, 'downloadPdf'])->name('pdf');
        });

        Route::prefix('purchases')->name('purchases.')->group(function () {
            Route::get('/', [PurchaseController::class, 'index'])->name('index');
            Route::get('{purchase}', [PurchaseController::class, 'show'])->name('show');
            Route::get('{purchase}/pdf', [PurchaseController::class, 'downloadPdf'])->name('pdf');
        });

        Route::prefix('items')->name('items.')->group(function () {
            Route::get('/', [ItemController::class, 'index'])->name('index');
            Route::get('{item}', [ItemController::class, 'show'])->name('show');
        });

        Route::prefix('item_types')->name('item_types.')->group(function () {
            Route::get('/', [ItemTypeController::class, 'index'])->name('index');
        });

        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('{post}', [PostController::class, 'show'])->name('show');
        });

        Route::prefix('workout_logs')->name('workout_logs.')->group(function () {
            Route::post('/', [WorkoutLogController::class, 'store'])->name('store');
        });

        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('index');
            Route::get('my', [BookingController::class, 'myBookings'])->name('my');
            Route::get('{booking}', [BookingController::class, 'show'])->name('show');
            Route::post('{booking}/register', [BookingController::class, 'register'])->name('register');
            Route::post('{booking}/unregister', [BookingController::class, 'unregister'])->name('unregister');
        });

        Route::prefix('ia')->name('ia.')->group(function () {
            Route::post('chat', [IAController::class, 'chat'])->name('chat');
        });
    });
});
