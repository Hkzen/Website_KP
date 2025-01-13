<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserDashboardController;
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

Route::get('/', [ProdukController::class, 'home'])->name('home');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/home', [ProdukController::class, 'home'])->name('home');
Route::get('/about', function () {
    return view('about', [
        "title" => "About"
    ]);
});

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

Route::get('/dashboard/produks/checkSlug', [DashboardProduksController::class , 'checkSlug'])->middleware('auth');
route::resource('/dashboard/produks', DashboardProduksController::class)->Middleware('auth');

Route::get('/dashboard/produks/{produk:slug}/edit', [DashboardProduksController::class, 'edit'])->middleware('auth')->name('produks.edit');
Route::put('/dashboard/produks/{produk:slug}', [DashboardProduksController::class, 'update'])->middleware('auth')->name('produks.update');
Route::delete('/dashboard/produks/{slug}', [DashboardProduksController::class, 'destroy'])->name('produks.destroy');

Route::get('/dashboard/kategori/checkSlug', [DashboardKategoriController::class, 'checkSlug'])->middleware('auth');

route::resource('/dashboard/kategori', DashboardKategoriController::class)->Middleware('auth');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->middleware('auth');
Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [CartController::class, 'viewCart'])->name('view.cart');
Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('remove.from.cart');

Route::get('/history', [CheckoutController::class, 'transactionHistory'])->name('transaction.history')->middleware('auth');

Route::resource('/dashboard/user', UserDashboardController::class)->middleware('auth');
Route::get('/dashboard/user/{user:id}/edit', [UserDashboardController::class, 'edit'])->middleware('auth')->name('user.edit');
Route::put('/dashboard/user/{user:id}', [UserDashboardController::class, 'update'])->middleware('auth')->name('user.update');
