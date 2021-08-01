<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("pengguna/login", [PenggunaController::class, "login"]);

Route::prefix('pengguna')->middleware("jwt.verify")->group(function () {
    Route::redirect("/", "/api/pengguna/tampil");
    Route::get("tampil", [PenggunaController::class, "index"]);
    Route::post("tampil", [PenggunaController::class, "cari"]);
    Route::post("tambah", [PenggunaController::class, "tambah"]);
    Route::delete("hapus", [PenggunaController::class, "hapus"]);
    Route::put("ubah", [PenggunaController::class, "ubah"]);
});
Route::prefix('artikel')->middleware("jwt.verify")->group(function () {
    Route::redirect("/", "/api/artikel/tampil");
    Route::get("tampil", [ArtikelController::class, "index"]);
    Route::post("tampil", [ArtikelController::class, "cari"]);
    Route::post("tambah", [ArtikelController::class, "tambah"]);
    Route::delete("hapus", [ArtikelController::class, "hapus"]);
    Route::put("ubah", [ArtikelController::class, "ubah"]);
});