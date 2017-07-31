<?php 

namespace App\Modulos\Actividad\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ActividadController extends Controller {


	public function inicio()
	{
		return view('Actividad.actividad');
	}


}