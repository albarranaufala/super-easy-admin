<?php

use App\Http\Controllers\CrudModuleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('modules', ModuleController::class);
    Route::get('crud/modules/{module}', [CrudModuleController::class, 'index'])->name('crud.modules.index');
    Route::get('crud/modules/{module}/create', [CrudModuleController::class, 'create'])->name('crud.modules.create');
    Route::post('crud/modules/{module}', [CrudModuleController::class, 'store'])->name('crud.modules.store');
    Route::get('crud/modules/{module}/{row}', [CrudModuleController::class, 'show'])->name('crud.modules.show');
    Route::get('crud/modules/{module}/{row}/edit', [CrudModuleController::class, 'edit'])->name('crud.modules.edit');
    Route::patch('crud/modules/{module}/{row}', [CrudModuleController::class, 'update'])->name('crud.modules.update');
    Route::delete('crud/modules/{module}/{row}', [CrudModuleController::class, 'destroy'])->name('crud.modules.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
