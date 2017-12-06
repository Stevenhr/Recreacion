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
Route::get('/welcome', 'MainController@welcome');
//rutas con filtro de autenticación
Route::group(['middleware' => ['web']], function () {
	
});


/*
|--------------------------------------------------------------------------
| Routes Actividad
|--------------------------------------------------------------------------
|Rutas para la gestion de los usuarios.
*/

Route::group(['prefix' => 'actividad', 'middleware' => 'auth'], function()
{
    $controller = "\\App\\Modulos\\ActividadRecreativa\\Controllers\\";

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

    Route::get('select_caracteristicas_especificas_poblacion/{id}',[
        'uses' => $controller.'ActividadController@select_caracteristicas_especificas_poblacion',
        'as' => 'seleccionar_caracteristicas_especificas_poblacion'
    ]);

    Route::post('disponibilidad_acopanante',[
        'uses' => $controller.'ActividadController@disponibilidad_acopanante',
        'as' => 'selecionar_barrio'
    ]);

    Route::post('validaPasos',[
        'uses' => $controller.'ActividadController@validaPasos',
        'as' => 'validaPasos'
    ]);

     Route::post('validarDatosActividad',[
        'uses' => $controller.'ActividadController@validarDatosActividad',
        'as' => 'validadatosactividad'
    ]);

    Route::get('eliminarDatosActividad/{id}',[
        'uses' => $controller.'ActividadController@eliminarDatosActividad',
        'as' => 'eliminadatosactividad'
    ]);

    Route::get('validardatosactividadregistrados/{id}',[
        'uses' => $controller.'ActividadController@validardatosactividadregistrados',
        'as' => 'validardatosactividadregistrados'
    ]);

});

Route::group(['prefix' => 'usuarios', 'middleware' => 'auth'], function()
{
    Route::get('distribuir', '\App\Modulos\Usuario\Controllers\DistribucionController@index');
    Route::post('asignarRol', '\App\Modulos\Usuario\Controllers\DistribucionController@asignarRol');
    Route::post('cargarRol', '\App\Modulos\Usuario\Controllers\DistribucionController@cargarRol');
});



