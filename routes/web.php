<?php

// routes/web.php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FarisBookController;
use App\Http\Controllers\FarisMemberController;
use App\Http\Controllers\FarisBorrowingController;
use App\Http\Controllers\FarisCategoryController;
use App\Http\Controllers\FarisLiteracyPointController;
use App\Http\Controllers\FarisReviewController;
use App\Http\Controllers\FarisReservationController; // New Reservation Controller
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Untuk logout
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

// --- Rute Autentikasi Manual ---
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// --- Rute Publik (Akses Terbuka) ---
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/books', [FrontendController::class, 'books'])->name('books.index');
Route::get('/books/{book}', [FrontendController::class, 'showBook'])->name('books.show');
Route::get('/about', [FrontendController::class, 'about'])->name('about');

// Route sementara untuk debugging dan setup admin
Route::get('/setup-admin', function() {
    $admin = \App\Models\User::firstOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin Pustaka',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]
    );

    return "Admin user created/updated: " . $admin->email . " (Role: " . $admin->role . ")";
});

Route::get('/check-user', function() {
    if (Auth::check()) {
        $user = Auth::user();
        $isAdmin = \Illuminate\Support\Facades\Gate::allows('admin', $user);
        return "Logged in as: " . $user->email . " (Role: " . $user->role . ")<br>Is Admin: " . ($isAdmin ? 'Yes' : 'No');
    }
    return "No user logged in";
});

// --- Rute yang Membutuhkan Autentikasi ---
Route::middleware('auth')->group(function () {
    // Dashboard Anggota
    Route::get('/dashboard', [FrontendController::class, 'dashboard'])->name('dashboard');

    // Pengajuan Peminjaman & Reservasi (Anggota)
    Route::post('/borrow/{book}', [FarisBorrowingController::class, 'requestBorrow'])->name('borrow.request');
    Route::post('/reserve/{book}', [FarisReservationController::class, 'store'])->name('reserve.store'); // Reservasi

    // Ulasan Buku
    Route::post('/books/{book}/review', [FarisReviewController::class, 'store'])->name('reviews.store');

    // --- Rute Admin (Akses Terbatas: role 'admin') ---
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Manajemen Buku
        Route::resource('books', FarisBookController::class);

        // Manajemen Anggota
        Route::resource('members', FarisMemberController::class);

        // Manajemen Peminjaman
        Route::get('borrowings', [FarisBorrowingController::class, 'index'])->name('borrowings.index');
        Route::post('borrowings/approve/{borrowing}', [FarisBorrowingController::class, 'approveBorrowing'])->name('borrowings.approve'); // Jika ada status pending
        Route::post('borrowings/return/{borrowing}', [FarisBorrowingController::class, 'returnBook'])->name('borrowings.return');
        Route::post('borrowings/cancel/{borrowing}', [FarisBorrowingController::class, 'cancelBorrowing'])->name('borrowings.cancel');

        // Manajemen Reservasi
        Route::get('reservations', [FarisReservationController::class, 'index'])->name('reservations.index');
        Route::post('reservations/mark-ready/{reservation}', [FarisReservationController::class, 'markReadyForPickup'])->name('reservations.mark_ready');
        Route::post('reservations/cancel/{reservation}', [FarisReservationController::class, 'cancelReservation'])->name('reservations.cancel');

        // Manajemen Kategori
        Route::resource('categories', FarisCategoryController::class);

        // Manajemen Poin Literasi (Admin bisa menambahkan/mengurangi poin manual)
        Route::get('literacy-points', [FarisLiteracyPointController::class, 'index'])->name('literacy_points.index');
        Route::get('literacy-points/create', [FarisLiteracyPointController::class, 'create'])->name('literacy_points.create'); // Form untuk tambah poin
        Route::post('literacy-points', [FarisLiteracyPointController::class, 'store'])->name('literacy_points.store'); // Simpan poin manual

        // Laporan dan Statistik
        Route::get('reports', [AdminController::class, 'reports'])->name('reports');
    });
});
