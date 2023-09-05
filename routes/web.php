<?php

use App\Http\Controllers\DropboxExampleController;
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
    return view('welcome');
});

Route::get('/dropbox/list', [DropboxExampleController::class, 'list']);
Route::get('/dropbox/listDirectories', [DropboxExampleController::class, 'listDirectories']);
Route::get('/dropbox/store', [DropboxExampleController::class, 'store']);
Route::get('/dropbox/store1', [DropboxExampleController::class, 'store1']);
Route::get('/dropbox/store2', [DropboxExampleController::class, 'store2']);
Route::get('/dropbox/store3', [DropboxExampleController::class, 'store3']);
Route::get('/dropbox/content', [DropboxExampleController::class, 'content']);
Route::get('/dropbox/exists', [DropboxExampleController::class, 'exists']);
Route::get('/dropbox/missing', [DropboxExampleController::class, 'missing']);
Route::get('/dropbox/prepend', [DropboxExampleController::class, 'prepend']);
Route::get('/dropbox/append', [DropboxExampleController::class, 'append']);
Route::get('/dropbox/copy', [DropboxExampleController::class, 'copy']);
Route::get('/dropbox/move', [DropboxExampleController::class, 'move']);
Route::get('/dropbox/delete', [DropboxExampleController::class, 'delete']);
Route::get('/dropbox/download', [DropboxExampleController::class, 'download']);
