<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


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


Route::get('/', [FileController::class, 'create'])->name('files.create');
Route::get('/files', [FileController::class, 'index'])->name('files.index');
Route::post('files/upload', [FileController::class, 'store'])->name('files.upload');
Route::get('/files/{file}/get-link',  [FileController::class, 'getFileLink'])->name('files.getLink');
Route::get('/{file}', [FileController::class, 'downloadFile'])->name('files.download');
