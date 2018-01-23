<?php 

namespace App\Modulos\ActividadRecreativa\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Modulos\ActividadRecreativa\ActividadRecreativa;
use App\Modulos\Usuario\ConfiguracionPersona;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;


class MisActividadesController extends Controller
{
	public function __construct(PersonaInterface $repositorio_personas)
	{
		$this->repositorio_personas = $repositorio_personas;
	}

	public function inicio()
	{
		
		return view('MisActividades.misActividades');
	}


	public function busquedaActividad(Request $request)
	{
		$messages = [
		    'fechaInicio.required'    => 'El campo :attribute se encuentra vacio.',
		    'fechaFin.required'    => 'El campo :attribute se encuentra vacio.',
		];

		$validator = Validator::make($request->all(),
	    [
			'fechaInicio' => 'required',
			'fechaFin' => 'required',
    	],$messages);
        
        if ($validator->fails())
        {
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }
        else
        {
			$actividades = ActividadRecreativa::whereBetween('d_fechaEjecucion',[$request['fechaInicio'],$request['fechaFin']])
			->where('i_fk_localidadComunidad',1)
			->get();

			$datos =[
				'actividadesPorRevisar'=>$actividades->where('i_estado', 0)->count(),
				'actividadesAprobadas'=>$actividades->where('i_estado', 1)->count(),
				'actividadesCanceladas'=>$actividades->where('i_estado', 2)->count(),
				'actividadesDenegadas'=>$actividades->where('i_estado', 3)->count(),
			];

            return response()->json(array('status' => 'ok', 'errors' => $validator->errors(), 'datos'=>$datos));
        }
    }

}