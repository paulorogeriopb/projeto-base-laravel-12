<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/offline', 'offline');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Auditoria
    Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');

    Route::get('/debug-locale', function () {
        return [
            'session_locale' => session('locale'),
            'app_locale' => app()->getLocale(),
        ];
    });

    Route::post('/change-language', function (Request $request) {
        session()->put('locale', $request->get('locale')); // <- usa 'locale' ao invés de 'app_locale'
        return back();
    })->name('change-language');


    // Traduções
    Route::prefix('translations')->middleware(['auth'])->group(function () {
        Route::get('/', [TranslationController::class, 'index'])->name('translations.index')->middleware('permission:translation-index');
        Route::get('/create', [TranslationController::class, 'create'])->name('translations.create')->middleware('permission:translation-create');
        Route::post('/', [TranslationController::class, 'store'])->name('translations.store')->middleware('permission:translation-create');
        Route::get('/{translation}/edit', [TranslationController::class, 'edit'])->name('translations.edit')->middleware('permission:translation-edit');
        Route::put('/{translation}', [TranslationController::class, 'update'])->name('translations.update')->middleware('permission:translation-edit');
        Route::delete('/{translation}', [TranslationController::class, 'destroy'])->name('translations.destroy')->middleware('permission:translation-destroy');
    });

    // Usuários
    Route::prefix('users')->group(function (): void {
        Route::get('/', [UserController::class, 'index'])->name('users.index')->middleware('permission:user-index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:user-create');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:user-show');
        Route::post('/', [UserController::class, 'store'])->name('users.store')->middleware('permission:user-create');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:user-edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:user-edit');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:user-destroy');

        Route::get('/{user}/edit-password', [UserController::class, 'editPassword'])->name('users.edit_password')->middleware('permission:users-edit-password');
        Route::put('/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update_password')->middleware('permission:users-edit-password');

        Route::patch('/{user}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus')->middleware('permission:user-status-edit');
    });

    // Usuários Status
    Route::prefix('user-statuses')->group(function (): void {
        Route::get('/', [UserStatusController::class, 'index'])->name('user_statuses.index')->middleware('permission:user-status-index');
        Route::get('/create', [UserStatusController::class, 'create'])->name('user_statuses.create')->middleware('permission:user-status-create');
        Route::get('/{userStatus}', [UserStatusController::class, 'show'])->name('user_statuses.show')->middleware('permission:user-status-show');
        Route::post('/', [UserStatusController::class, 'store'])->name('user_statuses.store')->middleware('permission:user-status-create');
        Route::get('/{userStatus}/edit', [UserStatusController::class, 'edit'])->name('user_statuses.edit')->middleware('permission:user-status-edit');
        Route::put('/{userStatus}', [UserStatusController::class, 'update'])->name('user_statuses.update')->middleware('permission:user-status-edit');
        Route::delete('/{userStatus}', [UserStatusController::class, 'destroy'])->name('user_statuses.destroy')->middleware('permission:user-status-destroy');
    });

    // Papéis
    Route::prefix('roles')->group(function (): void {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:role-index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:role-create');
        Route::get('/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:role-show');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:role-create');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:role-edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:role-edit');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:role-destroy');
    });

    // Permissão do papel
    Route::prefix('role-permissions')->group(function (): void {
        Route::get('/{role}', [RolePermissionController::class, 'index'])->name('role-permissions.index')->middleware('permission:permission-role-index');
        Route::patch('/{role}/{permission}', [RolePermissionController::class, 'update'])->name('role-permissions.update')->middleware('permission:permission-role-update');
        Route::patch('/{role}/toggle-user/{user}', [RolePermissionController::class, 'toggleUser'])->name('role-permissions.toggleUser')->middleware('permission:permission-role-update');
    });

    // Permissão
    Route::prefix('permissions')->group(function (): void {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:permission-index');
        Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:permission-create');
        Route::get('/{permission}', [PermissionController::class, 'show'])->name('permissions.show')->middleware('permission:permission-show');
        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:permission-create');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:permission-edit');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:permission-edit');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:permission-destroy');
    });

    // Auditoria

    // Cursos
    Route::get('/cursos', [CursosController::class, 'index'])->name('cursos.index')->middleware('permission:cursos-index');
    Route::get('/cursos/create', [CursosController::class, 'create'])->name('cursos.create')->middleware('permission:cursos-create');
    Route::post('/cursos', [CursosController::class, 'store'])->name('cursos.store')->middleware('permission:cursos-create');
    Route::get('/cursos/{curso}/edit', [CursosController::class, 'edit'])->name('cursos.edit')->middleware('permission:cursos-edit');
    Route::put('/cursos/{curso}', [CursosController::class, 'update'])->name('cursos.update')->middleware('permission:cursos-edit');
    Route::delete('/cursos/{curso}', [CursosController::class, 'destroy'])->name('cursos.destroy')->middleware('permission:cursos-destroy');
});

require __DIR__.'/auth.php';
