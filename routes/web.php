<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TolfeeController as AdminTolfeeController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthenticatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\VehicleController;
use App\Http\Controllers\WelcomeController;
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

// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::post('/tolgate', [WelcomeController::class, 'tol'])->name('tolgate');


Route::get('/dashboard', [AuthenticatorController::class, 'index'])->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:user']], function(){
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user-dashboard');

    //Route::get('/user/topup', [UserDashboardController::class, 'index'])->name('user-topup');

    Route::resource('vehicle', VehicleController::class);

    Route::resource('transactions', TransactionController::class);
});

Route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard');

    Route::resource('users', AdminUserController::class);

    Route::resource('tolfees', AdminTolfeeController::class);

    Route::get('/admin/transactions', [AdminTransactionController::class, 'index'])->name('admin-transactions');
});

require __DIR__.'/auth.php';
