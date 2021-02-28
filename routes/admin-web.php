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
//Ruta al home
Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();
// route to process the form

Route::get('/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/forgot', function () {
    return redirect('/password/reset');
});

Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');
Route::post('/reset_password_with_token','Auth\ResetPasswordController@resetPassword');

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/region/delete', 'RegionesController@deleteRegion')->middleware('auth');
// Route::post('/region/delete', 'RegionesController@deleteRegionByName')->middleware('auth');
// Route::get('/region/modify', 'RegionesController@showRegionToModify')->middleware('auth');

// Route::post('/region/create', 'RegionesController@createRegion')->middleware('auth');
// Route::post('/region/modify', 'RegionesController@modifyRegion')->middleware('auth');

// Route::post('/region/changeState', 'RegionesController@changeStateRegions')->middleware('auth')->name('changeState');


// Route::post('/region/selectRegion', 'RegionesController@showSelectedRegion')->middleware('auth');


// Route::get('/region/create', function(){
//     return view('regionCreate');
// });


Route::get('/display/getAll', 'DispositivosController@index')->middleware('auth')->name('dispositivos');

Route::post('/api/display/updateName', 'DispositivosController@updateName')->middleware('auth');

// Route::get('/display/add', 'DispositivosController@index')->middleware('auth')->name('dispositivos');
// Route::post('/display/add', 'DispositivosController@createDispositivo')->middleware('auth')->name('dispositivosCrear');
Route::get('/display/modify', 'DispositivosController@getSelectedContent')->middleware('auth')->name('dispositivosCambiar');
Route::post('/display/modify', 'DispositivosController@changeDisplayRegion')->middleware('auth')->name('dispositivosCambiar');
Route::post('/api/display/delete', 'DispositivosController@deleteDisplay')->middleware('auth')->name('dispositivosEliminar');



Route::get('/profile', 'UserController@changePasswordIndex')->middleware('auth')->name('cambiarContraseña');

Route::post('/changePassword', 'UserController@changePassword')->middleware('auth')->name('cambiarContraseña');
Route::post('/createUser', 'UserController@create')->middleware('auth')->name('createUser');
Route::post('/users/changestate', 'UserController@changestate')->middleware('auth')->name('cambiarEstado');

Route::post('/users/deleteUser', 'UserController@deleteUser')->middleware('auth')->name('deleteUser');
Route::post('/users/changeRoleUser', 'UserController@changeUserRol')->middleware('auth')->name('cambiarRol');


Route::get('/users', 'UserController@index')->middleware('auth')->name('dispositivos');



// Route::group(['middleware' => ['XssSanitizer']], function () {

//MODIFICAR CONTENIDO
Route::get('/content/modify', 'ContentController@getContentToModify')->middleware('auth');
Route::post('/content/selectContent', 'ContentController@getSelectedContent')->middleware('auth');
Route::get('/content/selectContentEmergency/{contentName}', 'ContentController@getSelectedContentEmergency')->middleware('auth');
//ALTA Y BAJA CONTENIDO
Route::get('/content/index', 'ContentController@index')->middleware('auth')->name('contenidos');
Route::get('/content/create', 'ContentController@create')->middleware('auth')->name('crearContenido');
Route::post('/content/store', 'ContentController@store')->middleware('auth')->name('guardarContenido');
Route::post('/content/update', 'ContentController@update')->middleware('auth')->name('actualizarContenido');
// });

Route::get('/content/delete',  'ContentController@delete')->middleware('auth')->name('deleteContenido');
Route::post('/content/delete/', 'ContentController@destroyContent')->middleware('auth')->name('borrarContenido');
Route::post('/content/delete/{contentName}', 'ContentController@destroy')->middleware('auth')->name('borrarContenido');
Route::post('/content/getById/{id}', 'ContentController@showByName')->middleware('auth')->name('detalleContenido');
Route::get('/content/getById/{id}', 'ContentController@showByName')->middleware('auth')->name('detalleContenido');

Route::get('/file/{hashName}', 'FileController@getFileById');

Route::get('/public', 'PublicController@create');



Route::get('/api/contenido/getAll/', 'PublicController@getAllData');

Route::get('/api/contenido/EnableDisableContent', 'PublicController@getDisableImage');

Route::get('/api/contenido/getById/{hashName}', 'PublicController@getById');

