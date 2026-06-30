<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeacherAccountController as AdminTeacherAccountController;
use App\Http\Controllers\Admin\TeacherAssignmentController as AdminTeacherAssignmentController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/guru/{slug}', [TeacherController::class, 'show'])->name('teachers.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:'.UserRole::ADMIN->value])
    ->group(function () {
        Route::get('/', DashboardController::class)->name('index');

        Route::resource('teachers', AdminTeacherController::class);

        Route::get('teachers/{teacher}/assignments/create', [AdminTeacherAssignmentController::class, 'create'])
            ->name('teachers.assignments.create');
        Route::post('teachers/{teacher}/assignments', [AdminTeacherAssignmentController::class, 'store'])
            ->name('teachers.assignments.store');
        Route::delete('teachers/{teacher}/assignments/{assignment}', [AdminTeacherAssignmentController::class, 'destroy'])
            ->name('teachers.assignments.destroy');

        Route::post('teachers/{teacher}/account', [AdminTeacherAccountController::class, 'store'])
            ->name('teachers.account.store');
        Route::patch('teachers/{teacher}/account/activate', [AdminTeacherAccountController::class, 'activate'])
            ->name('teachers.account.activate');
        Route::patch('teachers/{teacher}/account/deactivate', [AdminTeacherAccountController::class, 'deactivate'])
            ->name('teachers.account.deactivate');
        Route::patch('teachers/{teacher}/account/reset-password', [AdminTeacherAccountController::class, 'resetPassword'])
            ->name('teachers.account.reset-password');
    });

Route::prefix('portal-guru')
    ->name('teacher-portal.')
    ->middleware(['auth', 'role:'.UserRole::TEACHER->value])
    ->group(function () {
        Route::view('/', 'teacher-portal.index')->name('index');
    });
