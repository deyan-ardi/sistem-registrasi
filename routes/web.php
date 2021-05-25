<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('home');
Route::middleware(['auth', 'verified', 'admin'])->prefix('member')->group(function () {
    Route::get('/','MemberController@index')->name('member');
    Route::post('/create','MemberController@create')->name('create-member');
    Route::patch('/edit', 'MemberController@update')->name('edit-member');
    Route::post('/import-member', 'MemberController@import_excel')->name('import-member');
    Route::get('/export-member', 'MemberController@export_excel')->name('export-member');
    Route::delete('/delete/{member}', 'MemberController@destroy')->name('delete-member');
});


Route::middleware(['auth', 'verified', 'admin'])->prefix('setting')->group(function () {
    Route::get('/', 'SettingController@index')->name('setting');
    Route::patch('/edit-setting/{setting}', 'SettingController@update')->name('edit-setting');
});

Route::middleware(['auth', 'verified'])->prefix('activity')->group(function () {
    Route::get('/info', 'SettingController@info')->name('info');
    Route::get('/edit-profil', 'MemberController@show_profil')->name('edit-profil');
    Route::patch('/update-profil/{member}', 'MemberController@update_profil')->name('update-profil');
    Route::patch('/update-keamanan/{member}', 'MemberController@update_keamanan')->name('update-keamanan');
    Route::get('/change-email/{member}', 'MemberController@change_email')->name('change-email');
});