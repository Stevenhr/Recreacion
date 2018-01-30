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


class ConfirmarActividadesController extends Controller
{
	public function __construct(PersonaInterface $repositorio_personas)
	{
		$this->repositorio_personas = $repositorio_personas;
	}

	public function inicio()
	{

		return view('MisActividades.confirmacionActividades');
	}


	public function confirmarBusquedaActividad(Request $request)
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


			$actividades = ActividadRecreativa::where('i_fk_usuarioResponsable',$_SESSION['Usuario'][0])
			->whereBetween('d_fechaEjecucion',[$request['fechaInicio'],$request['fechaFin']])
			->get();



			$datos =[
				'actividadesConfirmadas'=>$actividades->where('i_estado',Configuracion::CONFIRMADO)->count(),
				'actividadesPorConfirmar'=>$actividades->where('i_estado', Configuracion::APROBADO)->count(),
			];

            return response()->json(array('status' => 'ok', 'errors' => $validator->errors(), 'datos'=>$datos));
        }
    }


    public function actividadesConfirmarResponsable(Request $request)
	{

		$actividades = ActividadRecreativa::with('datosActividad.programa','datosActividad.actividad','datosActividad.tematica','datosActividad.componente','acompanates')
		->where('i_fk_usuarioResponsable',$_SESSION['Usuario'][0])
		->whereBetween('d_fechaEjecucion',[$request['fechaInicioHiden'],$request['fechaFinHiden']])
		->where('i_estado',$request['opcion'])
		->get();
		
		$opcion="";
		$color="";
		$style="";
		
		if($request['opcion']==Configuracion::APROBADO){
			$opcion="Actividades en espera de confirmaciòn.";
			$color="default";
			$style ="color: black;background-color: #eeeeee;";

		}else if($request['opcion']==Configuracion::CONFIRMADO){
			$opcion="Actividades confirmadas.";
			$color="success";
			$style ="color: white;background-color: #6b9c35;";

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
		
		return view('MisActividades.tablaConfirmarActividad',$datos);
   
    }

    public function datosprogramacionactividad(Request $request, $id)
	{
		$actividad = ActividadRecreativa::with(['datosActividad' => function($query) {
			$query->with('programa', 'actividad','tematica','componente');
		} ,'acompanates','localidad_comunidad','upz_comunidad','barrio_comunidad','responsable','localidad_escenario', 'upz_escenario', 'barrio_escenario'])
		->find($id);

		return response()->json($actividad);
	}
	
}