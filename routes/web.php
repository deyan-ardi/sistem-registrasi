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
    Route::patch('/update-login/{member}', 'MemberController@update_login')->name('update-login');
    Route::delete('/delete/{member}', 'MemberController@destroy')->name('delete-member');
});

Route::middleware(['auth', 'verified','admin'])->prefix('vote')->group(function () {
    Route::get('/','VoteController@index')->name('vote');
    Route::get('/administrator/{vote}','VoteController@administrator')->name('administrator');
    Route::post('/create', 'VoteController@create')->name('create-vote');
    Route::patch('/update', 'VoteController@update')->name('edit-vote');
    Route::delete('/delete/{vote}', 'VoteController@destroy')->name('delete-vote');
    Route::patch('/activate/{vote}', 'VoteController@activate')->name('activate');
    Route::patch('/disable/{vote}', 'VoteController@disable')->name('disable');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('setting')->group(function () {
    Route::get('/', 'SettingController@index')->name('setting');
    Route::patch('/edit-setting/{setting}', 'SettingController@update')->name('edit-setting');
});

Route::middleware(['auth','verified'])->prefix('activity')->group(function () {
    Route::get('/live-count', 'DetailController@live')->name('live-count');
    Route::get('/voting-activity', 'DetailController@activity')->name('voting-activity');
    Route::patch('/update-vote/{vote}/{user}/{candidate}', 'DetailController@vote')->name('update-vote');
    Route::get('/info','SettingController@info')->name('info');
});

Route::middleware(['auth','verified','admin'])->prefix('detail')->group(function () {
    Route::get('/management-evote/{vote}', 'DetailController@index')->name('management-evote');
    Route::patch('/sinkronasi-pemilih/{vote}', 'DetailController@update')->name('sinkronasi-pemilih');
    Route::post('/reminder-evote/{user}/{vote}', 'DetailController@reminder')->name('reminder-vote');
    Route::post('/reminder-all/{vote}', 'DetailController@reminder_all')->name('reminder-all');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('candidate')->group(function () {
    Route::get('/management-candidate/{vote}','CandidateController@index')->name('management-candidate');
    Route::post('/create-candidate','CandidateController@create')->name('create-candidate');
    Route::patch('/update-candidate/{candidate}', 'CandidateController@update')->name('update-candidate');
    Route::delete('/delete/{candidate}/{vote}', 'CandidateController@destroy')->name('delete-candidate');
});