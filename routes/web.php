<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentationController as AdminDocumentationController;
use App\Http\Controllers\Admin\DocumentationMediaController as AdminDocumentationMediaController;
use App\Http\Controllers\Admin\OrganizationStructureController;
use App\Http\Controllers\Admin\RegistrationInformationController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\TeacherAccountController as AdminTeacherAccountController;
use App\Http\Controllers\Admin\TeacherAssignmentController as AdminTeacherAssignmentController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Public\DocumentationController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\RegistrationController;
use App\Http\Controllers\Public\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/guru/{slug}', [TeacherController::class, 'show'])->name('teachers.show');
Route::get('/dokumentasi', [DocumentationController::class, 'index'])->name('documentation.index');
Route::get('/pendaftaran', [RegistrationController::class, 'index'])->name('registration.index');

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

        Route::get('school-profile/information', [SchoolProfileController::class, 'information'])
            ->name('school-profile.information');

        Route::put('school-profile/information', [SchoolProfileController::class, 'update'])
            ->name('school-profile.update');

        Route::get('registration/information', [RegistrationInformationController::class, 'information'])
            ->name('registration.information');

        Route::put('registration/information', [RegistrationInformationController::class, 'update'])
            ->name('registration.update');

        Route::resource('organization-structures', OrganizationStructureController::class)
            ->only(['index', 'edit', 'update']);

        Route::resource('documentation-events', AdminDocumentationController::class)
            ->except(['show']);

        Route::post('documentation-events/{documentationEvent}/media', [AdminDocumentationMediaController::class, 'store'])
            ->name('documentation-events.media.store');
        Route::patch('documentation-events/{documentationEvent}/media/{media}', [AdminDocumentationMediaController::class, 'update'])
            ->name('documentation-events.media.update');
        Route::patch('documentation-events/{documentationEvent}/media/{media}/featured', [AdminDocumentationMediaController::class, 'setFeatured'])
            ->name('documentation-events.media.set-featured');
        Route::delete('documentation-events/{documentationEvent}/media/{media}', [AdminDocumentationMediaController::class, 'destroy'])
            ->name('documentation-events.media.destroy');

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
