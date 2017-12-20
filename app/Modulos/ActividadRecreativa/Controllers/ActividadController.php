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

		$resposanblesActividad = ConfiguracionPersona::with('persona')->where('i_id_tipo_persona',Configuracion::RESPOSANBLE_ACTIVIDAD)->whereIn('i_id_localidad',$locali)->groupBy('i_fk_id_persona')->get();

		$datos=[
            "localidades"=>$Localidad,
            "programas"=>$Programa,
            "caracteristicasPoblacion"=>$caracteristicaPoblacion,
            "resosablesActividad"=>$resposanblesActividad,
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

		$actividades = ActividadRecreativa::where('d_fechaEjecucion',$request['fecha_ejecucion'])
						->where('i_fk_localidadComunidad',$request['localidad_comunidad'])
						->where('i_fk_usuarioResponsable',$request['responsable'])
						->get();
		$opcion="";		
		$mensaje="";	
		$actividad=array();

		if($actividades->count())
		{
			foreach ($actividades as $dia) 
			{
				if(strtotime($hora_inicio) >= strtotime($dia['t_horaInicio']) 
				&& 
				   strtotime($hora_inicio) <= strtotime($dia['t_horaFin']))
				{
					$opcion='Error';
					$mensaje='Verfique hay un cruze de horarios 1';
					array_push($actividad,$dia['i_pk_id']);
				}else if(strtotime($hora_fin) >=  strtotime($dia['t_horaInicio'])
					&& 
				   strtotime($hora_fin) <= strtotime($dia['t_horaFin']))
				{
					$opcion='Error';
					$mensaje='Verfique hay un cruze de horarios 2';
					array_push($actividad,$dia['i_pk_id']);
				}else if(strtotime($hora_fin) >  strtotime($dia['t_horaFin'])
					&& 
				   strtotime($hora_inicio) < strtotime($dia['t_horaInicio']))
				{ 
					$opcion='Error';
					$mensaje='Verfique hay un cruze de horarios 3';
					array_push($actividad,$dia['i_pk_id']);
				}else{
					$opcion='Bien';
					$mensaje='Disponibilidad validada con éxito. No se encontró ningún cruce de horarios.1';
				}
			}
		}else{
			$opcion='Bien';
			$mensaje='Disponibilidad validada con éxito. No se encontró ningún cruce de horarios.2';
		}

		$actividadesCruzadas='';
		if(sizeof($actividad)>0){
				$actividadesCruzadas=ActividadRecreativa::whereIn('i_pk_id',$actividad)
						->get();
		}

		$tabla='<table class="table display no-wrap table-condensed table-bordered table-min" id="datos_actividad">
            <thead> 
                <tr class="active"> 
                    <th>#</th> 
                    <th>Programa</th> 
                    <th>Actividad</th> 
                    <th>Tematica</th> 
                    <th>Componente</th> 
                    <th>Eliminar</th> 
                </tr> 
            </thead>
                <tbody id="registros_datos">';

        $tabla=$tabla.'</tbody>
        </table>';

		//$confgu_persona = ConfiguracionPersona::with('persona')->where('i_id_localidad',strval($request['localidad_comunidad']))->where('i_id_tipo_persona',2)->get();
		$data =[
			'status'=>$opcion,
			'id_actividades'=>$tabla,
			'mensaje'=>$mensaje
		];
		return response()->json($data);
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
        return response()->json(array('status' => 'creado', 'datos' => $actividadrecreativa,'mensaje'=>'<div class="alert alert-success"><center><strong>DATOS DE LA COMUNIDAD REGISTRADOS:</strong></center><br><br>Datos registrados exitosamente en el sistema, la actividad <strong>'.$actividadrecreativa['i_pk_id'].'</strong> ya se encuentra en sus actividades, siga con el <strong>PASO II.</strong> Recuerde que debe completar los 5 pasos para que sea visible al responsable destinado para su aprobación. <br><br> <center><strong>ID: '.$actividadrecreativa['i_pk_id'].'</strong></center></div>'));
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
        return response()->json(array('status' => 'creado', 'datos' => $actividadrecreativa,'mensaje'=>'<div class="alert alert-success"><center><strong>DATOS DE LA COMUNIDAD ACTUALIZADOS:</strong></center><br><br>DATOS DE LA COMUNIDAD actualizados exitosamente en el sistema de la actividad <strong>'.$input['id'].'</strong>. Continue con el <strong>PASO II</strong><br><br><strong>Gracias!!!</strong></center></div>'));
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

        return response()->json(array('status' => 'creado', 'datos' => $datosActividadTodos,'mensaje'=>'<div class="alert alert-success"><center><strong>DATOS DE LA ACTIVIDAD REGISTRADOS:</strong></center><br><br>DATOS DE LA ACTIVIDAD registrados exitosamente en el sistema de la actividad <strong>'.$input['id'].'</strong>. Continue registrando más datos de la actividad o con el <strong>PASO III</strong><br><br><strong>Gracias!!!</strong></center></div>'));
    }

    public function eliminarDatosActividad(Request $request, $id)
	{
		$datoactivida = DatosActividad::find($id);
		$datoactivida->delete();
		$datosActividadTodos = DatosActividad::with('programa','actividad','tematica','componente')->where('i_fk_id_actividad',$datoactivida['i_fk_id_actividad'])->get();

		return response()->json(array('datos' => $datosActividadTodos,'mensaje'=>'<div class="alert alert-danger"><strong>DATO ELIMINADO:</strong><br><strong>Registro eliminado!!</Strong> Datos elimiando exitosamente.</div>'));
	}

	public function validardatosactividadregistrados(Request $request, $id)
	{
		
		$datoactivida = DatosActividad::where('i_fk_id_actividad',$id)->get();

		if($datoactivida->count()){
			$mensaje='<div class="alert alert-success"><center><strong>DATOS BASICOS DE LA ACTIVIDAD VALIDADOS:</strong></center><br><br>DATOS BASICOS DE LA ACTIVIDAD validados exitosamente en el sistema de la actividad <strong>'.$id.'</strong>. Continue con el <strong>PASO III</strong><br><br><strong>Gracias!!!</strong></center></div>';
			$status="ok";
		}else{
			$mensaje='<div class="alert alert-danger"><center><strong>DATOS INCOMPLETOS:</strong></center><br>No se han agregado los datos basicos de la actividad <strong>'.$id.'</strong>, siga con el <strong>PASO II.</strong><br><br><strong>Gracias!!!</strong></div>';
			$status="mal";
		}
		return response()->json(array('status' => $status, 'datos' => $datoactivida, 'mensaje'=>$mensaje));
	}



}