<?php 

namespace App\Modulos\ActividadRecreativa\Controllers;

use Illuminate\Http\Request;
use App\Localidad;
use App\Modulos\Parques\Upz;
use App\Modulos\Parques\Barrio;
use App\Modulos\ActividadRecreativa\ActividadRecreativa;
use App\Modulos\Programa\Programa;
use App\Modulos\Actividad\Actividad;
use App\Modulos\Componente\Componente;
use App\Modulos\Tematica\Tematica;
use App\Modulos\CaracteristicaPoblacion\CaracteristicaPoblacion;
use App\Modulos\CaracteristicaPoblacion\Elementoscaracteristicas;
use App\Modulos\Configuracion\Configuracion;
use App\Modulos\Usuario\ConfiguracionPersona;
use App\Http\Controllers\Controller;

class ActividadController extends Controller 
{

	public function inicio()
	{
		$Programa=Programa::where('IdPrograma','<>',7)->get();
		$caracteristicaPoblacion=CaracteristicaPoblacion::where('i_estado',0)->get();
		$Locali_gestor=ConfiguracionPersona::where('i_fk_id_persona',$_SESSION['Usuario'][0])->where('i_id_tipo_persona',Configuracion::GESTOR)->get();
		
		$locali[]="";
		$i=0;
		foreach ($Locali_gestor as $key) {
			$locali[$i]=$key['i_id_localidad'];
			$i++;
		}

		$Localidad = Localidad::whereIn('Id_Localidad',$locali)->get();

		$datos=[
            "localidades"=>$Localidad,
            "programas"=>$Programa,
            "caracteristicasPoblacion"=>$caracteristicaPoblacion,
            'punto' => null,
		];
		
		return view('Actividad.actividad',$datos);
	}

	public function select_actividad(Request $request, $id)
	{
		$actividades = Actividad::where('IdPrograma',$id)->get();
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
		
		$Locali_recreador=ConfiguracionPersona::where('i_id_localidad',$id)->where('i_id_tipo_persona',Configuracion::RESPOSANBLE_ACTIVIDAD)->get();

		$upzs = Upz::where('IdLocalidad',$id)->get();

		$datos=[
		'upzs'=>$upzs,
		'responsables'=>$Locali_recreador
		];
		return response()->json($datos);
	}

	public function select_barrio(Request $request, $id)
	{
		$upzs = Barrio::where('CodUpz',$id)->get();
		return response()->json($upzs);
	}

	public function select_caracteristicas_especificas_poblacion(Request $request, $id)
	{
		$especificos = Elementoscaracteristicas::where('i_fk_id_carac',$id)->get();
		return response()->json($especificos);
	}

	public function disponibilidad_acopanante(Request $request)
	{
		$hora_inicio = $request['hora_inicio'];
		$hora_fin = $request['hora_fin'];

		$actividades = ActividadRecreativa::where('d_fechaEjecucion',$request['fecha_ejecucion'])->where('i_fk_localidadComunidad',$request['localidad_comunidad'])->get();
		$opcion="";		
		$actividad="";	

			foreach ($actividades as $dia) {

				if(strtotime($hora_inicio) >= strtotime($dia['t_horaInicio']) 
				&& 
				   strtotime($hora_inicio) <= strtotime($dia['t_horaFin']))
				{
					$opcion='Verfique hay un cruze de horarios';
					$actividad=$actividad."   ".$dia['i_pk_id'];
				}
						
								
				if(strtotime($hora_fin) >=  strtotime($dia['t_horaInicio'])
					&& 
				   strtotime($hora_fin) <= strtotime($dia['t_horaFin']))
				{
					$opcion='Verfique hay un cruze de horarios';
					$actividad=$actividad."   ".$dia['i_pk_id'];
				}


				if(strtotime($hora_fin) >  strtotime($dia['t_horaFin'])
					&& 
				   strtotime($hora_inicio) < strtotime($dia['t_horaInicio']))
				{ 
					$opcion='Verfique hay un cruze de horarios';
					$actividad=$actividad."   ".$dia['i_pk_id'];
				}

			}


		//$confgu_persona = ConfiguracionPersona::with('persona')->where('i_id_localidad',strval($request['localidad_comunidad']))->where('i_id_tipo_persona',2)->get();
		$data =[
			'opcion'=>$opcion,
			'id_actividades'=>$actividad
		];
		return response()->json($data);
	}

}