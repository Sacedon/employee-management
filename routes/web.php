<?php

use Illuminate\Foundation\Application;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\AdminController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::get('/departments', [ManagementController::class, 'departments'])->name('departments');
    Route::get('/create-department', [ManagementController::class, 'create_department'])->middleware('role:admin')->name('department.create');
    Route::post('/create-department', [ManagementController::class, 'store_department'])->middleware('role:admin')->name('department.store');
    Route::get('/edit-department/{id}', [ManagementController::class, 'edit_department'])->middleware('role:admin')->name('department.edit');
    Route::patch('/update-department/{id}', [ManagementController::class, 'update_department'])->name('department.update');
    Route::get('/delete-department/{id}', [ManagementController::class, 'delete_department'])->middleware('role:admin')->name('department.delete');

    Route::get('/employees', [ManagementController::class, 'employees'])->name('employees');
    Route::get('/create-employee', [ManagementController::class, 'create_employee'])->middleware('role:admin')->name('employee.create');
    Route::post('/create-employee', [ManagementController::class, 'store_employee'])->middleware('role:admin')->name('employee.store');
    Route::get('/edit-employee/{id}', [ManagementController::class, 'edit_employee'])->middleware('role:admin')->name('employee.edit');
    Route::patch('/update-employee/{id}', [ManagementController::class, 'update_employee'])->name('employee.update');
    Route::get('/delete-employee/{id}', [ManagementController::class, 'delete_employee'])->middleware('role:admin')->name('employee.delete');
    Route::get('/employees/search/{searchKey}', [ManagementController::class, 'search']);

    Route::get('/employees/pdf/{employee}',[ManagementController::class,'pdf'])->name('employee.pdf');;
    Route::get('/employees/email/{employee}', [ManagementController::class, 'email'])->middleware('role:admin')->name('employee.email');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('role:admin');
    Route::post('/admin/email', [AdminController::class, 'sendEmailToAllEmployees'])->name('admin.bulk-mail');
});


