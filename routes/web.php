<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('download', function () {
    $data = request()->validate([
        'path' => 'required',
        'filename' => 'required',
    ]);

    return response()->download(
        decrypt($data['path']),
        $data['filename']
    )->deleteFileAfterSend(true);
})->name('laravel-nova-excel.download')->middleware('signed');
