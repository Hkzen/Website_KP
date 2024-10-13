<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProdukFilterController;
use App\Http\Controllers\DashboardProduksController;
use App\Http\Controllers\DashboardKategoriController;
use App\Http\Controllers\DashboardProduksFilterController;

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
    return view('home', [
        "title" => "Home"
    ]);
});

Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produkFilter', [ProdukFilterController::class, 'filterProducts']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login',[LoginController::class, 'authenticate']);
Route::post('/logout',[LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register',[RegisterController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    });
});

Route::get('/dashboard/produks/checkSlug', [DashboardProduksController::class , 'checkSlug'])->middleware('auth');
route::resource('/dashboard/produks', DashboardProduksController::class)->Middleware('auth');
Route::get('/dashboard/produksFilter', [DashboardProduksFilterController::class, 'filterProducts']);

Route::get('/dashboard/produks/{produk:slug}/edit', [DashboardProduksController::class, 'edit'])->middleware('auth')->name('produks.edit');
Route::put('/dashboard/produks/{produk:slug}', [DashboardProduksController::class, 'update'])->middleware('auth')->name('produks.update');
Route::delete('/dashboard/produks/{slug}', [DashboardProduksController::class, 'destroy'])->name('produks.destroy');

Route::get('/dashboard/kategori/checkSlug', [DashboardKategoriController::class, 'checkSlug'])->middleware('auth');

route::resource('/dashboard/kategori', DashboardKategoriController::class)->Middleware('auth');
