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
				'actividadesAprobadas'=>$actividades->whereIn('i_estado', [Configuracion::APROBADO,Configuracion::CONFIRMADO])->count(),
				'actividadesDenegadas'=>$actividades->where('i_estado', Configuracion::DEVUELTO)->count(),
				'actividadesCanceladas'=>$actividades->where('i_estado', Configuracion::CANCELADO)->count(),
			];

            return response()->json(array('status' => 'ok', 'errors' => $validator->errors(), 'datos'=>$datos));
        }
    }


    public function actividadesResposableProgramaPendientes(Request $request)
	{

		$persona_programa=ConfiguracionPersona::where('i_fk_id_persona',$_SESSION['Usuario'][0])
    	->where('i_id_tipo_persona',Configuracion::RESPOSANBLE_PROGRAMA)
    	->get();

    	$tipo_programa=$persona_programa->pluck('i_fk_programa')->unique()->all();

		$actividades = ActividadRecreativa::with('datosActividad.programa','datosActividad.actividad','datosActividad.tematica','datosActividad.componente','acompanates')->whereHas('datosActividad',function($query) use ($tipo_programa){
			$query->whereIn('i_fk_programa',$tipo_programa);
		})
		->whereBetween('d_fechaEjecucion',[$request['fechaInicioHiden'],$request['fechaFinHiden']])
		->get();
		
		$opcion="";
		$color="";
		$style="";
		
		if($request['opcion']==Configuracion::PENDIENTE){
			$opcion="Actividades en espera de revisón.";
			$color="default";
			$style ="color: black;background-color: #eeeeee;";
			$actividades=$actividades->where('i_estado',Configuracion::PENDIENTE);

		}else if($request['opcion']==Configuracion::APROBADO){
			$opcion="Actividades aprobadas.";
			$color="success";
			$style ="color: white;background-color: #6b9c35;";
			$actividades=$actividades->whereIn('i_estado',[Configuracion::APROBADO,Configuracion::CONFIRMADO]);

		}else if($request['opcion']==Configuracion::DEVUELTO){
			$opcion="Actividades denegadas.";
			$color="warning";
			$style ="color: white;background-color: #dd5600;";
			$actividades=$actividades->where('i_estado',Configuracion::DEVUELTO);

		}else if($request['opcion']==Configuracion::CANCELADO){
			$opcion="Actividades canceladas.";
			$color="danger";
			$style ="color: white;background-color: #c71c22;";
			$actividades=$actividades->where('i_estado',Configuracion::CANCELADO);

		}else{
			$opcion="";
			$color="";
			$style="";
		}

		$datos=[
			'actividades'=>$actividades,
			'tipo'=>$opcion,
			'color'=>$color,
			'style'=>$style,
		];
		
		return view('MisActividades.tablaMisActividades',$datos);
   
    }

    public function datosprogramacionactividad(Request $request, $id)
	{
		$actividad = ActividadRecreativa::with(['datosActividad' => function($query) {
			$query->with('programa', 'actividad','tematica','componente');
		} ,'acompanates','localidad_comunidad','upz_comunidad','barrio_comunidad','responsable','localidad_escenario', 'upz_escenario', 'barrio_escenario'])
		->find($id);

		return response()->json($actividad);
	}

	public function actividadConfirmada(Request $request, $id)
	{
		$actividad = ActividadRecreativa::find($id);
		$actividad['i_estado']=4;
		$actividad->save();
		return response()->json(array('mensaje' => '<span class="label label-success">Aprobado</span>'));
	}

	public function actividadDevuelta(Request $request, $id)
	{
		$actividad = ActividadRecreativa::find($id);
		$actividad['i_estado']=2;
		$actividad->save();
		return response()->json(array('mensaje' => '<span class="label label-warning">Devuelto</span>'));
	}

	public function actividadCancelada(Request $request, $id)
	{
		$actividad = ActividadRecreativa::find($id);
		$actividad['i_estado']=3;
		$actividad->save();
		return response()->json(array('mensaje' => '<span class="label label-danger">Cancelada</span>'));
	}
	
}