<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\Admin\BooksAdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersAdminController;

use App\Http\Controllers\User\UserController;

// Group untuk admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginAdmin'])->name('loginAdmin');
    Route::post('/login', [AdminLoginController::class, 'loginAdmin'])->name('loginAdmin');
    Route::get('/logout', [AdminLoginController::class, 'logoutAdmin'])->name('logoutAdmin');

    // Route::get('/dashboard', [AdminLoginController::class, 'dashboardAdmin'])->name('dashboardAdmin');
    // Route buku admin
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/dashboard', [AdminLoginController::class, 'dashboardAdmin'])->name('dashboardAdmin');
        Route::get('/admin/profile', [AdminController::class, 'getAdmin'])->name('getAdmin');
        Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('updateProfile');
        Route::resource('/adminaction', AdminController::class);
        Route::resource('usersAdmin', UsersAdminController::class);

        // Edit Profil pribadi
        // Route::get('/getAdmin', [AdminController::class, 'getAdmin'])->name('getAdmin');
        

        // Route::get('/adminProfile', [AdminController::class, 'adminProfile'])->name('adminProfile');

        Route::get('/books', [BookController::class, 'index'])->name('booksAdmin.index');

        Route::resource('/booksAdmin', BooksAdminController::class);
        
        Route::resource('/categoryAdmin', CategoryController::class);
        Route::resource('/loansAdmin', LoanController::class);
    });
    // Route::resource('booksAdmin', BooksAdminController::class);

    // Dashboard Admin hanya bisa diakses oleh admin yang sudah login
    // Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        
    // });
});

// Jika / diakses, maka akan diarahkan ke login user
Route::get('/', function () {
    return redirect()->route('loginUser');
});

// Group untuk user
Route::prefix('user')->group(function () {
    Route::post('/login', [UserLoginController::class, 'loginUser'])->name('loginUser');
    Route::get('/login', [UserLoginController::class, 'showLoginUser'])->name('loginUser');
    Route::get('/logout', [UserLoginController::class, 'logoutUser'])->name('logoutUser');

    // Dashboard User hanya bisa diakses oleh user yang sudah login
    Route::middleware([\App\Http\Middleware\UserMiddleware::class])->group(function () {
        Route::get('/dashboard', [UserLoginController::class, 'dashboard'])->name('dashboard');
        Route::get('/user/profile', [UserController::class, 'getUser'])->name('getUser');
        Route::put('/user/profile/update', [UserController::class, 'updateProfileUser'])->name('updateProfileUser');
    });
});
