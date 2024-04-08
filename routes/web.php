<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SendTugasController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;
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
    return redirect()->route('dashboard.login');
});


Route::controller(DashboardController::class)->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', 'index')->name('dashboard.index');
        Route::get('/peringkat', 'peringkat')->name('dashboard.peringkat');
        Route::get('/progress', 'tingkat')->name('dashboard.tingkat');
        Route::get('/logout', 'logout')->name('dashboard.logout');
    });
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', 'login')->name('dashboard.login');
        Route::post('/login', 'authentication')->name('dashboard.authentication');
    });
});


Route::middleware(['auth'])->group(function () {
    Route::middleware('guru')->group(function () {
        Route::resource('penilaian', PenilaianController::class);
    });

    Route::resource('send-tugas', SendTugasController::class);
    Route::resource('tugas', TugasController::class);
    Route::resource('mata-pelajaran', MataPelajaranController::class);

    Route::middleware('admin')->group(function () {
        Route::resource('user-manejement', UserController::class);
        Route::get('user-manejement/search', [SearchController::class, 'user'])->name('search.user');
        Route::get('pelajaran/search', [SearchController::class, 'mata_pelajaran'])->name('search.mata-pelajaran');
    });
});
