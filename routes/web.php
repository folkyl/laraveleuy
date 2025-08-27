<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\siswaController;
use App\Http\Controllers\kontenController;

Route::get('/', [kontenController::class, 'landing'])->name('landing');
Route::get('/login', [adminController::class, 'formLogin'])->name('login');
Route::post('/login', [adminController::class, 'prosesLogin'])->name('login.post');
Route::get('/home', [siswaController::class, 'home'])->name('home');
Route::get('/siswa/create', [siswaController::class, 'create'])->name('siswa.create');
Route::post('/siswa/store', [siswaController::class, 'store'])->name('siswa.store');
Route::get('/siswa/{id}/edit', [siswaController::class, 'edit'])->name('siswa.edit');
Route::post('/siswa/{id}/update', [siswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
Route::get('/logout', [adminController::class, 'logout'])->name('logout');
Route::get('/register', [adminController::class, 'formregister'])->name('register');
Route::post('/register', [adminController::class, 'prosesRegister'])->name('register.post');
Route::get('/detil/{id}', [kontenController::class, 'detil'])->name('detil');