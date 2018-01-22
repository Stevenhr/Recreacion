<?php 

namespace App\Modulos\ActividadRecreativa\Controllers;

use Illuminate\Http\Request;
use App\Localidad;
use App\Persona;
use App\Modulos\Parques\Upz;
use App\Modulos\Parques\Barrio;
use App\Modulos\ActividadRecreativa\ActividadRecreativa;
use App\Modulos\ActividadRecreativa\DatosActividad;
use App\Modulos\Programa\Programa;
use App\Modulos\Actividad\Actividad;
use App\Modulos\Componente\Componente;
use App\Modulos\Tematica\Tematica;
use App\Modulos\Usuario\Acompanante;
use App\Modulos\CaracteristicaPoblacion\CaracteristicaPoblacion;
use App\Modulos\CaracteristicaPoblacion\Elementoscaracteristicas;
use App\Modulos\Configuracion\Configuracion;
use App\Modulos\Usuario\ConfiguracionPersona;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use Validator;


class MisActividades extends Controller
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
		
		return view('MisActividades.misActividades',$datos);
	}

}