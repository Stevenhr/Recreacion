<?php

namespace App\Modulos\ActividadRecreativa;

use Illuminate\Database\Eloquent\Model;

class ActividadRecreativa extends Model
{
    //
    protected $table = 'actividadrecreodeportiva';
	protected $primaryKey = 'i_pk_id';
	protected $fillable = ['d_fechaEjecucion','t_horaInicio','t_horaFin','i_fk_usuario','i_fk_usuarioResponsable','vc_direccion','vc_escenario','vc_codigoParque','i_fk_localidadEscenario','i_fk_upzEscenario','i_fk_barrioEscenario','i_fk_localidadComunidad','i_fk_upzComunidad','i_fk_barrioComunidad','vc_institutoGrupoComunidad','vc_caracteristicaPoblacion','i_numeroAsistentes','t_horaImplementacion','vc_puntoEncuentro','vc_personaContacto','vc_rollComunidad','i_telefono','i_estado'];
	protected $connection = ''; 
	public $timestamps = true;


    public function datosActividad()
    {
        return $this->hasMany('App\DatosActividad','i_fk_id_actividad');
    }

}

