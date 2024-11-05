<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
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

Route::middleware(['isGuest'])->group(function (){
    Route::get('/', [AkunController::class, "login"])->name('login');
    
    Route::post('/login', [AkunController::class, 'loginAuth'])->name('login.auth');
});

Route::get('error-permission',function(){
    return view('error-permission');
})->name('error-permission');

Route::middleware(['IsLogin'])->group(function(){
// Route::get('/',function(){
//     return view('login');
// })->name('login');
Route::post('/logout', [AkunController::class, 'logout'])->name('logout');
Route::get('/home', [Controller::class, 'landing'])->name('home');

Route::middleware(['IsAdmin'])->group(function(){

    Route::prefix('/medicines')->name('medicines.')->group(function(){
        Route::get('/add', [MedicineController::class, 'create'])->name('create');
        Route::post('/add', [MedicineController::class, 'store'])->name('store');
        Route::get('/ada', [MedicineController::class, 'index'])->name('index');
        // {id} : path dinamis berisi data id, path dinamis untuk mencari spesifikasi data berdasarkan field tertentu
        Route::delete('/delete/{id}', [MedicineController::class, 'destroy'])->name('delete');
        Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
        Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('update');
        Route::patch('/edit/stock/{id}', [MedicineController::class, 'updateStock'])->name('update.stock');
    });

    Route::prefix('/acc')->name('acc.')->group(function (){
        Route::get('/Akun',[AkunController::class , 'index'])->name('akun');
        Route::get('/BuatAkun',[AkunController::class , 'create'])->name('create');
        Route::post('/BuatAkunBaru',[AkunController::class , 'store'])->name('store');
        Route::get('/edit/{id}',[AkunController::class , 'edit'])->name('edit');
        Route::patch('/edit/{id}',[AkunController::class , 'update'])->name('update');
        Route::delete('/{id}',[AkunController::class , 'destroy'])->name('destroy');
    });

});
});

Route::get('/pembelian',[OrderController::class,'index'])->name('pembelian');
Route::get('/pembelian/create',[OrderController::class,'create'])->name('tambah.pembelian');
Route::post('/pembelian/beli',[OrderController::class,'store'])->name('beli.store');
