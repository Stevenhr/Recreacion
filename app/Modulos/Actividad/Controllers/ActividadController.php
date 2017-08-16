<?php 

namespace App\Modulos\Actividad\Controllers;

use Illuminate\Http\Request;
use App\Localidad;
use App\Modulos\ActividadRecreativa\ActividadRecreativa;
use App\Modulos\Programa\Programa;
use App\Modulos\Componente\Componente;
use App\Modulos\Tematica\Tematica;
use App\Http\Controllers\Controller;

class ActividadController extends Controller {

	public function inicio()
	{
		$Programa=Programa::where('IdPrograma','<>',7)->get();
		$Localidad=Localidad::all();
		
		$datos=[
		"localidades"=>$Localidad,
		"programas"=>$Programa
		];
		
		return view('Actividad.actividad',$datos);
	}

	public function select_actividad(Request $request, $id)
	{
		$actividades = ActividadRecreativa::where('IdPrograma',$id)->get();
		return response()->json($actividades);
	}

	public function select_tematica(Request $request, $id)
	{
		$tematica = Tematica::where('IdActividad',$id)->get();
		return response()->json($tematica);
	}

	public function select_componente(Request $request, $id)
	{
		$componente = Componente::where('IdTematica',$id)->get();
		return response()->json($componente);
	}

}