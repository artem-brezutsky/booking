<?php

/**
 * Web Routes
 *
 * Here is where you can register web routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * contains the "web" middleware group. Now create something great!
 *
 */

use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('front.pages.home');
});

// Testing send mail
//Route::get('/test', 'TestController@testCreateUser');

// Authentication Routes...
Route::group(['namespace' => 'Auth'], static function () {
    Route::get('/login', 'LdapLoginController@showLoginForm')->name('login');
    Route::post('/login', 'LdapLoginController@login');
    Route::post('/logout', 'LdapLoginController@logout')->name('logout');
});

Route::group(['middleware' => 'auth'], static function () {

    /**
     * Группа роутов для отображения фронта
     */
    Route::group(['namespace' => 'Front', 'prefix' => '/studios'], static function () {
        Route::get('/', 'StudioController@index')->name('studio.show_all_studio');
        Route::get('/{studio}/events/', 'EventController@index')->name('events.index');
        Route::get('/{studio}/events/load', 'EventController@load')->name('events.load');
        Route::post('/{studio}/events/create', 'EventController@create')->name('events.addEvent');
        Route::delete('/{studio}/events/destroy', 'EventController@destroy')->name('events.deleteEvent');
        // PDF Generate
        Route::post('/get-pdf/', 'PdfController@index')->name('output.pdf');
    });

    /**
     * Група роутов для админ панели
     */
    Route::group([
        'namespace'  => 'Admin',
        'prefix'     => 'admin',
        'middleware' => 'can:isAdmin' // Проверка является ли пользователь Админом перед тем как заходить в админку
    ], static function () {
        // Стартовая страница админки
        Route::get('/', 'AdminController@index')->name('admin.dashboard');
        // События
        Route::get('/events', 'EventController@index')->name('admin.events_list');
        Route::delete('/events/destroy/{eventID}', 'EventController@destroy')->name('admin.delete_event');
        // "Комнаты"
        Route::resource('/studios', 'StudioController');
        // Пользователи
        Route::resource('/users', 'UserController');
    });

});