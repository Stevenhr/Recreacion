<?php 

namespace App\Modulos\ActividadRecreativa\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Modulos\ActividadRecreativa\ActividadRecreativa;
use App\Modulos\Usuario\ConfiguracionPersona;
use App\Modulos\Configuracion\Configuracion;
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

        	$persona_programa=ConfiguracionPersona::where('i_fk_id_persona',$_SESSION['Usuario'][0])
        	->where('i_id_tipo_persona',Configuracion::RESPOSANBLE_PROGRAMA)
        	->get();

        	$tipo_programa=$persona_programa->pluck('i_fk_programa')->unique()->all();

			$actividades = ActividadRecreativa::whereHas('datosActividad',function($query) use ($tipo_programa){
				$query->whereIn('i_fk_programa',$tipo_programa);
			})
			->whereBetween('d_fechaEjecucion',[$request['fechaInicio'],$request['fechaFin']])
			->get();



			$datos =[
				'actividadesPorRevisar'=>$actividades->where('i_estado',Configuracion::PENDIENTE)->count(),
				'actividadesAprobadas'=>$actividades->where('i_estado', Configuracion::APROBADO)->count(),
				'actividadesDenegadas'=>$actividades->where('i_estado', Configuracion::DEVUELTO)->count(),
				'actividadesCanceladas'=>$actividades->where('i_estado', Configuracion::CANCELADO)->count(),
			];

            return response()->json(array('status' => 'ok', 'errors' => $validator->errors(), 'datos'=>$datos));
        }
    }

}