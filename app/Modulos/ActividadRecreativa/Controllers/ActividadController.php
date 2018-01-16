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
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;


class ActividadController extends Controller 
{
	public function __construct(PersonaInterface $repositorio_personas)
	{
		$this->repositorio_personas = $repositorio_personas;
	}

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
		$Localidades = Localidad::all();

		$resposanblesActividad = ConfiguracionPersona::with('persona')->where('i_id_tipo_persona',Configuracion::RESPOSANBLE_ACTIVIDAD)->whereIn('i_id_localidad',$locali)->groupBy('i_fk_id_persona')->get();

		$datos=[
            "localidades"=>$Localidad,
            "TodasLocalidades"=>$Localidades,
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
            return response()->json(array('status' => 'Campos', 'errors' => $validator->errors()));


		$hora_inicio = $request['hora_inicio'];
		$hora_fin = $request['hora_fin'];

		$actividades = ActividadRecreativa::where('d_fechaEjecucion',$request['fecha_ejecucion'])
						->where('i_fk_localidadComunidad',$request['localidad_comunidad'])
						->where('i_fk_usuarioResponsable',$request['responsable'])
						->where('i_pk_id','<>',$request['id'])
						->get();
		$opcion="";		
		$mensaje="";	
		$actividad=array();

		if($actividades->count()>0)
		{
			foreach ($actividades as $dia) 
			{
				if(strtotime($hora_inicio) >= strtotime($dia['t_horaInicio']) 
				&& 
				   strtotime($hora_inicio) <= strtotime($dia['t_horaFin']))
				{
					$opcion='Error';
					$mensaje='Los datos que intenta ingresar tienen un cruce de horarios con una o mas actividades ya registradas. Por favor valide y registre nuevamente los datos. ';
					array_push($actividad,$dia['i_pk_id']);
				}else if(strtotime($hora_fin) >=  strtotime($dia['t_horaInicio'])
					&& 
				   strtotime($hora_fin) <= strtotime($dia['t_horaFin']))
				{
					$opcion='Error';
					$mensaje='Los datos que intenta ingresar tienen un cruce de horarios con una o mas actividades ya registradas. Por favor valide y registre nuevamente los datos. ';
					array_push($actividad,$dia['i_pk_id']);
				}else if(strtotime($hora_fin) >  strtotime($dia['t_horaFin'])
					&& 
				   strtotime($hora_inicio) < strtotime($dia['t_horaInicio']))
				{ 
					$opcion='Error';
					$mensaje='Los datos que intenta ingresar tienen un cruce de horarios con una o mas actividades ya registradas. Por favor valide y registre nuevamente los datos. ';
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
				$actividadesCruzadas=ActividadRecreativa::whereIn('i_pk_id',$actividad)->get();
		}

		$tabla='<table class="table display no-wrap table-condensed table-bordered table-min" id="datos_actividad">
            <thead> 
                <tr class="active"> 
                    <th>#</th> 
                    <th>Id</th> 
                    <th>Fecha</th> 
                    <th>Hora incio</th> 
                    <th>Hora fin</th> 
                </tr> 
            </thead>
                <tbody>';
            $num=1;
            if($actividadesCruzadas!=''){
                foreach ($actividadesCruzadas as $atividadmet) {
                    // dd($atividadmet);
                    $tabla=$tabla."<tr class='danger'>
                        <td>".$num."</td>
                        <td><center>".$atividadmet['i_pk_id']."</center></td>
                        <td >".$atividadmet['d_fechaEjecucion']."</td>
                        <td>".$atividadmet['t_horaInicio']."</td>
                        <td>".$atividadmet['t_horaFin']."</td>
                    </tr>";
                    $num++;
                }
            }
        $tabla=$tabla.'</tbody>
        </table>';

		//$confgu_persona = ConfiguracionPersona::with('persona')->where('i_id_localidad',strval($request['localidad_comunidad']))->where('i_id_tipo_persona',2)->get();
		if($opcion=='Bien'){
	        $persona = $this->repositorio_personas->obtener($request['responsable']);
	        
	        $actividadrecreativa =  ActividadRecreativa::find($request['id']);
	        $actividadrecreativa['d_fechaEjecucion']=$request['fecha_ejecucion'];
			$actividadrecreativa['t_horaInicio']=$request['hora_inicio'];
			$actividadrecreativa['t_horaFin']=$request['hora_fin'];
			$actividadrecreativa['i_fk_usuarioResponsable']=$request['responsable'];
			$actividadrecreativa->save();

			$datosvalidados=[
				'hora_inicio'=>$request['hora_inicio'],
				'hora_fin'=>$request['hora_fin'],
				'fecha_ejecucion'=>$request['fecha_ejecucion'],
				'localidad_comunidad'=>$request['localidad_comunidad'],
				'responsable'=>$request['responsable'],
				'responsablenombre'=>$persona
			];
		}else{
			$datosvalidados=[
				'hora_inicio'=>'',
				'hora_fin'=>'',
				'fecha_ejecucion'=>'',
				'localidad_comunidad'=>'',
				'responsable'=>'',
				'responsablenombre'=>''
			];
		}	

		$data =[
			'status'=>$opcion,
			'id_actividades'=>$tabla,
			'mensaje'=>$mensaje,
			'request'=>$datosvalidados
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
        $actividadrecreativa['i_fk_usuario']=$_SESSION['Usuario'][0];
        $actividadrecreativa['i_fk_localidadComunidad']=$input['localidad_comunidad'];
		$actividadrecreativa['i_fk_upzComunidad']=$input['Id_Upz_Comunidad'];
		$actividadrecreativa['i_fk_barrioComunidad']=$input['Id_Barrio_Comunidad'];
		$actividadrecreativa['vc_institutoGrupoComunidad']=$input['institucion_g_c'];
		$actividadrecreativa['vc_caracteristicaPoblacion']=json_encode($input['datosCaracterisitica']);
		$actividadrecreativa->save();
        return response()->json(array('status' => 'creado', 'datos' => $actividadrecreativa,'mensaje'=>'<div class="alert alert-success"><center><strong>DATOS DE LA COMUNIDAD REGISTRADOS:</strong></center><br><br>Datos registrados exitosamente en el sistema, la actividad <strong>'.$actividadrecreativa['i_pk_id'].'</strong> ya se encuentra en sus actividades, siga con el <strong>PASO II.</strong> Recuerde que debe completar los 5 pasos para que sea visible al responsable destinado para su aprobación. <br><br> <center><strong>ID: '.$actividadrecreativa['i_pk_id'].'</strong></center></div>'));
    }

     public function modificar_datos_comunidad($input)
    {
        $actividadrecreativa =  ActividadRecreativa::find($input['id']);
        $actividadrecreativa['i_fk_usuario']=$_SESSION['Usuario'][0];
        $actividadrecreativa['i_fk_localidadComunidad']=$input['localidad_comunidad'];
		$actividadrecreativa['i_fk_upzComunidad']=$input['Id_Upz_Comunidad'];
		$actividadrecreativa['i_fk_barrioComunidad']=$input['Id_Barrio_Comunidad'];
		$actividadrecreativa['vc_institutoGrupoComunidad']=$input['institucion_g_c'];
		$actividadrecreativa['vc_caracteristicaPoblacion']=json_encode($input['datosCaracterisitica']);
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

		if($datoactivida->count()>0){
			$mensaje='<div class="alert alert-success"><center><strong>DATOS BASICOS DE LA ACTIVIDAD VALIDADOS:</strong></center><br><br>DATOS BASICOS DE LA ACTIVIDAD validados exitosamente en el sistema de la actividad <strong>'.$id.'</strong>. Continue con el <strong>PASO III</strong><br><br><strong>Gracias!!!</strong></center></div>';
			$status="ok";
		}else{
			$mensaje='<div class="alert alert-danger"><center><strong>DATOS INCOMPLETOS:</strong></center><br>No se han agregado los datos basicos de la actividad <strong>'.$id.'</strong>, registre el <strong>PASO II.</strong><br><br><strong>Gracias!!!</strong></div>';
			$status="mal";
		}
		return response()->json(array('status' => $status, 'datos' => $datoactivida, 'mensaje'=>$mensaje));
	}


	public function validardatosactividadregistradospasoIII(Request $request, $id)
	{
		
		$datoactivida = ActividadRecreativa::find($id);
		
		if($datoactivida->count()>0)
		{
		    if($datoactivida['d_fechaEjecucion']!='')
			{
				$mensaje='<div class="alert alert-success"><center><strong>DATOS BASICOS DE LA ACTIVIDAD VALIDADOS:</strong></center><br><br>DATOS BASICOS DE LA ACTIVIDAD validados exitosamente en el sistema de la actividad <strong>'.$id.'</strong>. Continue con el <strong>PASO III</strong><br><br><strong>Gracias!!!</strong></center></div>';
				$status="ok";
			}
			else
			{
				$mensaje='<div class="alert alert-danger"><center><strong>DATOS INCOMPLETOS:</strong></center><br>No se han agregado la programación y asignación de la actividad <strong>'.$id.'</strong>, registre el <strong>PASO III.</strong><br><br><strong>Gracias!!!</strong></div>';
				$status="mal";
			}
		}
		return response()->json(array('status' => $status, 'datos' => $datoactivida, 'mensaje'=>$mensaje));
	}


	public function validardatosactividadregistradosPasoIV(Request $request)
	{
		$messages = [
		    'Direccion.required'    => 'El campo :attribute se encuentra vacio.',
		    'Escenario.required'    => 'El campo :attribute se encuentra vacio.',
		    'localidad_escenario.required'      => 'El campo :attribute se encuentra vacio.',
		    'Id_Upz_escenario.required'      => 'El campo :attribute se encuentra vacio.',
		    'Id_Barrio_escenario.required'      => 'El campo :attribute se encuentra vacio.',
		    'Latitud.required'      => 'El campo :attribute se encuentra vacio.',
		    'Longitud.required'      => 'El campo :attribute se encuentra vacio.',
		];

		$validator = Validator::make($request->all(),
	    [
			'Direccion' => 'required',
			'Escenario' => 'required',
			'localidad_escenario' => 'required',
			'Id_Upz_escenario' => 'required',
			'Id_Barrio_escenario' => 'required',
			'Latitud' => 'required',
			'Longitud' => 'required',
    	],$messages);
        
        if ($validator->fails()){
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }
        else{
        	return $this->crear_datos_escenario($request->all());
        }
    }



    public function crear_datos_escenario($input)
    {
		//Latitud
		//Longitud

		$actividadrecreativa =  ActividadRecreativa::find($input['id']);
	    $actividadrecreativa['i_fk_localidadEscenario']=$input['localidad_escenario'];
		$actividadrecreativa['i_fk_upzEscenario']=$input['Id_Upz_escenario'];
		$actividadrecreativa['i_fk_barrioEscenario']=$input['Id_Barrio_escenario'];
		$actividadrecreativa['vc_direccion']=$input['Direccion'];
		$actividadrecreativa['vc_escenario']=$input['Escenario'];
		$actividadrecreativa->save();

        return response()->json(array('status' => 'creado', 'datos' => $actividadrecreativa,'mensaje'=>'<div class="alert alert-success"><center><strong>DATOS DE LA ACTIVIDAD REGISTRADOS:</strong></center><br><br>DATOS DEL ESCENARIO registrados exitosamente en el sistema de la actividad <strong>'.$input['id'].'</strong>. Continue registrando los aspectos a tener en cuenta <strong>PASO V</strong><br><br><strong>Gracias!!!</strong></center></div>'));
    }




    public function registroActividadPasoV(Request $request)
	{
		$messages = [
		    'hora_implementacion.required'    => 'El campo :attribute se encuentra vacio.',
		    'punto_encuentro.required'    => 'El campo :attribute se encuentra vacio.',
		    'nombre_persona.required'      => 'El campo :attribute se encuentra vacio.',
		    'roll_comunidad.required'      => 'El campo :attribute se encuentra vacio.',
		    'telefono_persona.required'      => 'El campo :attribute se encuentra vacio.',
		];

		$validator = Validator::make($request->all(),
	    [
			'hora_implementacion' => 'required',
			'punto_encuentro' => 'required',
			'nombre_persona' => 'required',
			'roll_comunidad' => 'required',
			'telefono_persona' => 'required',
    	],$messages);
        
        if ($validator->fails()){
            return response()->json(array('status' => 'error', 'errors' => $validator->errors()));
        }
        else
        {
        	return $this->crear_registro_actividad($request->all());
        }
    }

    public function crear_registro_actividad($input)
    {

		$actividadrecreativa =  ActividadRecreativa::find($input['id']);
	    $actividadrecreativa['t_horaImplementacion']=$input['hora_implementacion'];
		$actividadrecreativa['vc_puntoEncuentro']=$input['punto_encuentro'];
		$actividadrecreativa['vc_personaContacto']=$input['nombre_persona'];
		$actividadrecreativa['vc_rollComunidad']=$input['roll_comunidad'];
		$actividadrecreativa['i_telefono']=$input['telefono_persona'];
		$actividadrecreativa->save();
        return response()->json(array('status' => 'creado', 'datos' => $actividadrecreativa,'mensaje'=>'<div class="alert alert-success"><center><strong>ACTIVIDAD REGISTRADA EXITOSAMENTE:</strong><br><br><img src="../public/Img/Institucionales/iconoModulo.png" class="rounded mx-auto d-block" alt="..."><br><br><strong>Gracias!!!</strong></center></div>'));
    }



}