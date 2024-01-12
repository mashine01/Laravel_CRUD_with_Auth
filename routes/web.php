<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::GET('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::PATCH('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::DELETE('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::GET("/employee", [EmployeeController::class, 'index'])->name('employee.index');
    Route::GET("/employee/create", [EmployeeController::class, 'create'])->name('employee.create');
    Route::POST("/employee/store", [EmployeeController::class, 'store'])->name('employee.store');
    Route::GET("/employee/{employee}/edit", [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::PUT("/employee/{employee}/update", [EmployeeController::class, 'update'])->name('employee.update');
    Route::DELETE("/employee/{employee}/destroy", [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::GET("/employee/downloadData", [ExcelController::class, 'download_with_data'])->name('excel.downloadData');
    Route::GET("/employee/download", [ExcelController::class, 'download_without_data'])->name('excel.download');
    Route::POST("/employee/upload", [ExcelController::class, 'upload_data'])->name('excel.upload');

});

require __DIR__.'/auth.php';