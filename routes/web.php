<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PengaduanController;
use App\Http\Controllers\Backend\PetugasController;
use App\Http\Controllers\Backend\PenggunaController;
use App\Http\Controllers\Backend\StatistikController;
use App\Http\Controllers\Backend\PengaturanController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ComplaintController;
use App\Http\Controllers\Petugas\PetugasController as PetugasControllerClass;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/register', [HomeController::class, 'register'])->name('register');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard redirect route
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Password reset routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Pengaduan routes
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.update-status');
    Route::put('/pengaduan/{id}/assign', [PengaduanController::class, 'assignPetugas'])->name('pengaduan.assign-petugas');
    
    // Statistik route
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');
    
    // Petugas routes
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas');
    Route::get('/petugas/{id}', [PetugasController::class, 'show'])->name('petugas.show');
    Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');
    Route::put('/petugas/{id}', [PetugasController::class, 'update'])->name('petugas.update');
    Route::delete('/petugas/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
    
    // Pengguna routes
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('/pengguna/{id}', [PenggunaController::class, 'show'])->name('pengguna.show');
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
    
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::post('/pengaturan/sistem', [PengaturanController::class, 'sistemUpdate'])->name('pengaturan.sistem');
});

// User routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
    
    // Complaint routes
    Route::resource('complaints', ComplaintController::class);
});

// Petugas routes
Route::middleware(['auth'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasControllerClass::class, 'dashboard'])->name('dashboard');
    Route::get('/complaints', [PetugasControllerClass::class, 'complaints'])->name('complaints');
    Route::get('/complaints/{complaint}', [PetugasControllerClass::class, 'showComplaint'])->name('complaints.show');
    Route::post('/complaints/{complaint}/assign', [PetugasControllerClass::class, 'assignComplaint'])->name('complaints.assign');
    Route::post('/complaints/{complaint}/update-status', [PetugasControllerClass::class, 'updateComplaintStatus'])->name('complaints.update-status');
    Route::get('/statistics', [PetugasControllerClass::class, 'statistics'])->name('statistics');
    Route::get('/profile', [PetugasControllerClass::class, 'profile'])->name('profile');
});

// Legacy routes for old sidebar (redirect to admin routes)
Route::middleware(['auth'])->group(function () {
    Route::get('/pengaduan', function () {
        return redirect()->route('admin.pengaduan');
    })->name('pengaduan.index');
    
    Route::get('/kategori', function () {
        return redirect()->route('admin.pengaduan');
    })->name('kategori.index');
    
    Route::get('/users', function () {
        return redirect()->route('admin.pengguna');
    })->name('users.index');
    
    Route::get('/petugas', function () {
        return redirect()->route('admin.petugas');
    })->name('petugas.index');
    
    Route::get('/profile', function () {
        return redirect()->route('admin.pengaturan');
    })->name('profile.edit');
}); 