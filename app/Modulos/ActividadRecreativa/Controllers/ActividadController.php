<?php 

namespace App\Modulos\ActividadRecreativa\Controllers;

use Illuminate\Http\Request;
use App\Localidad;
use App\Modulos\Parques\Upz;
use App\Modulos\Parques\Barrio;
use App\Modulos\ActividadRecreativa\ActividadRecreativa;
use App\Modulos\ActividadRecreativa\DatosActividad;
use App\Modulos\Programa\Programa;
use App\Modulos\Actividad\Actividad;
use App\Modulos\Componente\Componente;
use App\Modulos\Tematica\Tematica;
use App\Modulos\CaracteristicaPoblacion\CaracteristicaPoblacion;
use App\Modulos\CaracteristicaPoblacion\Elementoscaracteristicas;
use App\Modulos\Configuracion\Configuracion;
use App\Modulos\Usuario\ConfiguracionPersona;
use App\Http\Controllers\Controller;
use Validator;


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

		$messages = [
		    'responsable.required'    => 'El campo :attribute se encuentra vacio.',
		    'fecha_ejecucion.required'    => 'El campo :attribute se encuentra vacio.',
		    'hora_inicio.required' => 'El campo :attribute se encuentra vacio.',
		    'hora_fin.required'      => 'El campo :attribute se encuentra vacio.',
		];


		$validator = Validator::make($request->all(),
	    [
			'responsable' => 'required',
			'fecha_ejecucion' => 'required',
			'hora_inicio' => 'required',
			'hora_fin' => 'required',
    	],$messages);
        
        if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));


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
		return response()->json(array('status' => 'bien', 'errors' =>$data));
	}


	public function validaPasos(Request $request)
	{
		$messages = [
		    'localidad_comunidad.required'    => 'El campo :attribute se encuentra vacio.',
		    'Id_Upz_Comunidad.required'    => 'El campo :attribute se encuentra vacio.',
		    'Id_Barrio_Comunidad.required' => 'El campo :attribute se encuentra vacio.',
		    'institucion_g_c.required'      => 'El campo :attribute se encuentra vacio.',
		    'caracteristicaPoblacion.required'      => 'El campo :attribute se encuentra vacio.',
		    'caracteristicaEspecifica.required'      => 'El campo :attribute se encuentra vacio.',
		];


		$validator = Validator::make($request->all(),
	    [
			'localidad_comunidad' => 'required',
			'Id_Upz_Comunidad' => 'required',
			'Id_Barrio_Comunidad' => 'required',
			'institucion_g_c' => 'required',
			'caracteristicaPoblacion' => 'required',
			'caracteristicaEspecifica' => 'required',
    	],$messages);
        
        if ($validator->fails())
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        

        if($request->input('id') == '0')
        {
            return $this->crear_datos_comunidad($request->all());
        }
        else
        {
            return $this->modificar_datos_comunidad($request->all());  
        }
    }

    public function crear_datos_comunidad($input)
    {
        $actividadrecreativa = new ActividadRecreativa;
        $actividadrecreativa['i_fk_localidadComunidad']=$input['localidad_comunidad'];
		$actividadrecreativa['i_fk_upzComunidad']=$input['Id_Upz_Comunidad'];
		$actividadrecreativa['i_fk_barrioComunidad']=$input['Id_Barrio_Comunidad'];
		$actividadrecreativa['vc_institutoGrupoComunidad']=$input['institucion_g_c'];
		$actividadrecreativa['vc_caracteristicaPoblacion']=$input['caracteristicaPoblacion'];
		$actividadrecreativa->save();
        return response()->json(array('status' => 'creado', 'datos' => $actividadrecreativa,'mensaje'=>'<strong>DATOS DE LA COMUNIDAD REGISTRADOS:</strong><br><strong>Registro Realizado!!</Strong> Datos registrados exitosamente.'));
    }

     public function modificar_datos_comunidad($input)
    {
        $actividadrecreativa =  ActividadRecreativa::find($input['id']);
        $actividadrecreativa['i_fk_localidadComunidad']=$input['localidad_comunidad'];
		$actividadrecreativa['i_fk_upzComunidad']=$input['Id_Upz_Comunidad'];
		$actividadrecreativa['i_fk_barrioComunidad']=$input['Id_Barrio_Comunidad'];
		$actividadrecreativa['vc_institutoGrupoComunidad']=$input['institucion_g_c'];
		$actividadrecreativa['vc_caracteristicaPoblacion']=$input['caracteristicaPoblacion'];
		$actividadrecreativa->save();
        return response()->json(array('status' => 'creado', 'datos' => $actividadrecreativa,'mensaje'=>'<strong>DATOS DE LA COMUNIDAD MODIFICADOS:</strong><br><Strong>Modificación Realizada!!</Strong> Datos modificados exitosamente.'));
    }



    public function validarDatosActividad(Request $request)
	{
		$messages = [
		    'programa.required'    => 'El campo :attribute se encuentra vacio.',
		    'actividad.required'    => 'El campo :attribute se encuentra vacio.',
		    'tematica.required'    => 'El campo :attribute se encuentra vacio.',
		    'componente.required'    => 'El campo :attribute se encuentra vacio.',
		];


		$validator = Validator::make($request->all(),
	    [
			'programa' => 'required',
			'actividad' => 'required',
			'tematica' => 'required',
			'componente' => 'required',
    	],$messages);
        
        if ($validator->fails()){
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }
        else
        {
            return $this->crear_datos_actividad($request->all());
        }
    }


    public function crear_datos_actividad($input)
    {

        $datosActividad = new DatosActividad;
        $datosActividad['i_fk_id_actividad']=$input['id'];
		$datosActividad['i_fk_programa']=$input['programa'];
		$datosActividad['i_fk_actividad']=$input['actividad'];
		$datosActividad['i_fk_tematica']=($input['tematica']=='')?null:$input['tematica'];
		$datosActividad['i_fk_componente']=($input['componente']=='')?null:$input['componente'];
		$datosActividad->save();

		$datosActividadTodos = DatosActividad::with('programa','actividad','tematica','componente')->where('i_fk_id_actividad',$input['id'])->get();

        return response()->json(array('status' => 'creado', 'datos' => $datosActividadTodos,'mensaje'=>'<strong>DATOS DE LA ACTIVIDAD REGISTRADOS:</strong><br><strong>Registro Realizado!!</Strong> Datos registrados exitosamente.'));
    }

    public function eliminarDatosActividad(Request $request, $id)
	{
		$datoactivida = DatosActividad::find($id);
		$datoactivida->delete();
		$datosActividadTodos = DatosActividad::with('programa','actividad','tematica','componente')->where('i_fk_id_actividad',$datoactivida['i_fk_id_actividad'])->get();

		return response()->json(array('datos' => $datosActividadTodos,'mensaje'=>'<strong>DATO ELIMINADO:</strong><br><strong>Registro eliminado!!</Strong> Datos elimiando exitosamente.'));
	}

	public function validardatosactividadregistrados(Request $request, $id)
	{
		
		$datoactivida = DatosActividad::where('i_fk_id_actividad',$id)->get();

		if($datoactivida->count()){
			$mensaje="<strong>BIEN!!</strong> Sigue con el siguiente paso de la programación y asignación de la actividad";
			$status="ok";
		}else{
			$mensaje="<strong>DATOS INCOMPLETOS:</strong> No se han registrado los datos basicos de la actividad.";
			$status="mal";
		}
		return response()->json(array('status' => $status, 'datos' => $datoactivida, 'mensaje'=>$mensaje));
	}



}