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
        return $this->hasMany('App\Modulos\ActividadRecreativa\DatosActividad','i_fk_id_actividad');
    }

    public function gestor()
    {
        return $this->belongsTo('App\Persona','i_fk_usuario');
    }

    public function responsable()
    {
        return $this->belongsTo('App\Persona','i_fk_usuarioResponsable');
    }

    public function acompanates()
    {
        return $this->hasMany('App\Modulos\Usuario\Acompanante','i_fk_id_actividad');
    }

    public function localidad_comunidad()
    {
        return $this->belongsTo('App\Modulos\Parques\Localidad','i_fk_localidadComunidad');
    }

    public function upz_comunidad()
    {
        return $this->belongsTo('App\Modulos\Parques\Upz','i_fk_upzComunidad');
    }

    public function barrio_comunidad()
    {
        return $this->belongsTo('App\Modulos\Parques\Barrio','i_fk_barrioComunidad');
    }

    public function localidad_escenario()
    {
        return $this->belongsTo('App\Modulos\Parques\Localidad','i_fk_localidadEscenario');
    }

    public function upz_escenario()
    {
        return $this->belongsTo('App\Modulos\Parques\Upz','i_fk_upzEscenario');
    }

    public function barrio_escenario()
    {
        return $this->belongsTo('App\Modulos\Parques\Barrio','i_fk_barrioEscenario');
    }

    public function datos_caracteristicas()
    {
      return $this->belongsToMany('App\Modulos\CaracteristicaPoblacion\Elementoscaracteristicas','caracteristicas_actividad','i_fk_id_actividadrecreodeportiva','i_fk_id_elementoscaracteristicas')->withPivot('created_at');
    }

}

