<?php 

namespace App\Modulos\Actividad\Controllers;

use App\Http\Requests;
use App\Localidad;
use App\Programa;
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


}