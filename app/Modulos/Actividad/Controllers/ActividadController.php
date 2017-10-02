<?php 

namespace App\Modulos\Actividad\Controllers;

use Illuminate\Http\Request;
use App\Localidad;
use App\Modulos\Parques\Upz;
use App\Modulos\Parques\Barrio;
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
            "programas"=>$Programa,
            'punto' => null,
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

	public function select_upz(Request $request, $id)
	{
		$upzs = Upz::where('IdLocalidad',$id)->get();
		return response()->json($upzs);
	}

	public function select_barrio(Request $request, $id)
	{
		$upzs = Barrio::where('CodUpz',$id)->get();
		return response()->json($upzs);
	}

}