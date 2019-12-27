<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route permohonan tuntutan
// Route::get('tuntutan', 'TuntutanController@index');
// Route::get('tuntutan/tambah', 'TuntutanController@create');
// Route::post('tuntutan/tambah', 'TuntutanController@store');
// Route::get('tuntutan/{id}/edit', 'TuntutanController@edit');
// Route::patch('tuntutan/{id}/edit', 'TuntutanController@update');
// Route::destroy('tuntutan/{id}', 'TuntutanController@destroy');
// Route::get('tuntutan/datatables', 'TuntutanController@datatables');

// Route pengurusan admin
Route::group([
    'middleware' => ['auth', 'admin.only'], 
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'as' => 'admin.'
], 
function () {

    Route::get('tuntutan/datatables', 'TuntutanController@datatables')->name('tuntutan.datatables');
    Route::get('tuntutan/export', 'TuntutanExportController@export')->name('tuntutan.export');
    Route::get('tuntutan/pdf', 'TuntutanExportController@pdf')->name('tuntutan.pdf');
    Route::post('tuntutan/{id}/status', 'TuntutanStatusController@update')->name('tuntutan.status.update');
    Route::resource('tuntutan', 'TuntutanController');

});

// Route pengurusan kewangan admin
Route::group([
    'middleware' => ['auth', 'kewangan.only'], 
    'prefix' => 'kewangan',
    'namespace' => 'Kewangan',
    'as' => 'kewangan.'
], 
function () {

    Route::get('tuntutan/datatables', 'TuntutanController@datatables')->name('tuntutan.datatables');
    Route::get('tuntutan/export', 'TuntutanExportController@export')->name('tuntutan.export');
    Route::get('tuntutan/pdf', 'TuntutanExportController@pdf')->name('tuntutan.pdf');
    Route::post('tuntutan/{id}/status', 'TuntutanStatusController@update')->name('tuntutan.status.update');
    Route::resource('tuntutan', 'TuntutanController');

});

// Route pengurusan pengguna
Route::group([
    'middleware' => ['auth'], 
    'prefix' => 'pengguna',
    'namespace' => 'Pengguna',
    'as' => 'pengguna.'
], 
function () {

    // Rekod Tuntutan
    Route::get('tuntutan/datatables', 'TuntutanController@datatables')->name('tuntutan.datatables');
    Route::get('tuntutan/export', 'TuntutanExportController@export')->name('tuntutan.export');
    Route::get('tuntutan/pdf', 'TuntutanExportController@pdf')->name('tuntutan.pdf');
    Route::resource('tuntutan', 'TuntutanController');

    // Rekod Individu
    Route::get('individu/datatables', 'IndividuController@datatables')->name('individu.datatables');
    Route::resource('individu', 'IndividuController');

});
