<?php
session_start();
/*
|--------------------------------------------------------------------------
| Routes Usuarios
|--------------------------------------------------------------------------
|Rutas para la gestion de los usuarios.
*/
Route::get('/personas', '\Idrd\Usuarios\Controllers\PersonaController@index');
Route::get('/personas/service/obtener/{id}', '\Idrd\Usuarios\Controllers\PersonaController@obtener');
Route::get('/personas/service/buscar/{key}', '\Idrd\Usuarios\Controllers\PersonaController@buscar');
Route::get('/personas/service/ciudad/{id_pais}', '\Idrd\Usuarios\Controllers\LocalizacionController@buscarCiudades');
Route::post('/personas/service/procesar/', '\Idrd\Usuarios\Controllers\PersonaController@procesar');

Route::get('/actividad_usuario/{identificacion?}', function ($identificacion = null) {
return view('idrd.usuarios.persona_actividades', [
'seccion' => 'Actividades',
'identificacion' => $identificacion
]);
});
Route::get('/usuario_tipo', function () { return view('persona_tipoPersona'); });
Route::get('/asignarActividad', '\Idrd\Usuarios\Controllers\AsignarActividadController@asignarActividades');
Route::get('/actividadesModulo', '\Idrd\Usuarios\Controllers\AsignarActividadController@moduloActividades');
Route::get('/actividadesPersona/{id}', '\Idrd\Usuarios\Controllers\AsignarActividadController@personaActividades');
Route::any('PersonasActividadesProceso', '\Idrd\Usuarios\Controllers\AsignarActividadController@PersonasActividadesProceso');
Route::any('/', 'MainController@index');
Route::any('/logout', 'MainController@logout');

Route::any('/', 'MainController@index');
Route::any('/logout', 'MainController@logout');

//rutas con filtro de autenticación
Route::group(['middleware' => ['web']], function () {
	Route::get('/welcome', 'MainController@welcome');
});


/*
|--------------------------------------------------------------------------
| Routes Actividad
|--------------------------------------------------------------------------
|Rutas para la gestion de los usuarios.
*/

Route::group(['prefix' => 'actividad', 'middleware' => 'auth'], function()
{
    $controller = "\\App\\Modulos\\Actividad\\Controllers\\";

    Route::any('/registroActividad', [
        'uses' => $controller.'ActividadController@inicio',
        'as' => 'proceso_actividad'
    ]);

    Route::get('select_actividad/{id}',[
        'uses' => $controller.'ActividadController@select_actividad',
        'as' => 'selecionar_actividad'
    ]);

    Route::get('select_tematica/{id}',[
        'uses' => $controller.'ActividadController@select_tematica',
        'as' => 'selecionar_tematica'
    ]);

    Route::get('select_componente/{id}',[
        'uses' => $controller.'ActividadController@select_componente',
        'as' => 'selecionar_componente'
    ]);

    Route::get('select_upz/{id}',[
        'uses' => $controller.'ActividadController@select_upz',
        'as' => 'selecionar_upz'
    ]);

    Route::get('select_barrio/{id}',[
        'uses' => $controller.'ActividadController@select_barrio',
        'as' => 'selecionar_barrio'
    ]);


    Route::post('disponibilidad_acopanante',[
        'uses' => $controller.'ActividadController@disponibilidad_acopanante',
        'as' => 'selecionar_barrio'
    ]);
});



