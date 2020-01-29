<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route permohonan tuntutan
/*Route::get('tuntutan', 'TuntutanController@index');
Route::get('tuntutan/tambah', 'TuntutanController@create');
Route::get('tuntutan', 'TuntutanController@store');
Route::get('tuntutan/{id}/edit', 'TuntutanController@update');
Route::get('tuntutan/{id}', 'TuntutanController@destroy');*/
//Route::get('tuntutan', 'Pengguna\TuntutanController@datatables'); //untuk tambahan function

Route::group(['middleware' => ['auth']],
	function() 
	{
		//Rekod Tuntutan
		Route::get('tuntutan/datatables', 'Pengguna\TuntutanController@datatables')->name('tuntutan.datatables');
		Route::get('tuntutan/export', 'Pengguna\TuntutanExportController@export')->name('tuntutan.export');
		Route::get('tuntutan/pdf', 'Pengguna\TuntutanExportController@pdf')->name('tuntutan.pdf');
		Route::post('tuntutan/{id}/status','Pengguna\TuntutanStatusController@update')->name('tuntutan.status.update');
		Route::resource('tuntutan', 'Pengguna\TuntutanController');
	});

Route::group([
	['middleware' => ['auth', 'adminSemak.only', 'adminSah.only' ]],
	'prefix' => 'admin',
    'namespace' => 'Admin',
    'as' => 'admin.' 
	], 
	function() 
	{
		Route::get('individu/dataSenaraiTanggungan', 'IndividuController@dataSenaraiTanggungan')->name('individu.dataSenaraiTanggungan');
		Route::post('individu/{id}/status', 'IndividuStatusController@update')->name('individu.status.update');
		Route::resource('individu', 'IndividuController');
	});

/*Route::group([
	'middleware' => ['auth', 'adminLulus.only'],
	'prefix' => 'admin',
    'namespace' => 'Admin',
    'as' => 'admin.' 
	], 
	function() 
	{
		Route::get('individu/dataSenaraiTanggungan', 'IndividuController@dataSenaraiTanggungan')->name('individu.dataSenaraiTanggungan');
		Route::post('individu/{id}/status', 'IndividuStatusController@update')->name('individu.status.update');
		Route::resource('individu', 'IndividuController');
	});*/



Route::get('individu/dataSenaraiTanggungan', 'Pengguna\IndividuController@dataSenaraiTanggungan')->name('individu.dataSenaraiTanggungan');
Route::post('ajaxKiraUmur', 'Pengguna\IndividuController@ajaxKiraUmur');
Route::post('ajaxSetStatusAktif', 'Pengguna\IndividuController@ajaxSetStatusAktif');
Route::resource('individu', 'Pengguna\IndividuController');

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

Route::get('/pengguna', function(){

	$users = DB::connection('mysqldbrujukan')
	->select('select * from tblpengguna');
	

	//die and dump
	dd($users);
});

Route::get('pengguna/{id}', function($id){

	$pengguna = DB::connection('mysqldbrujukan')
	->select('select * from tblpengguna WHERE id = :id', ['id' => $id]);

	dd($pengguna);
});

Route::get('password', function() {
	return bcrypt('password');
});