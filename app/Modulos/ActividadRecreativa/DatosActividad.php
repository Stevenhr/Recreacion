<?php

namespace App\Modulos\ActividadRecreativa;

use Illuminate\Database\Eloquent\Model;

class DatosActividad extends Model
{
    //
    protected $table = 'datosactividadrecreodeportiva';
	protected $primaryKey = 'i_pk_id';
	protected $fillable = ['i_fk_id_actividad','i_fk_programa','i_fk_actividad','i_fk_tematica','i_fk_componente'];
	protected $connection = ''; 
	public $timestamps = true;


	public function actividadrecreativa()
    {
        return $this->belongsTo('App\ActividadRecreativa','i_fk_id_actividad');
    }

    public function programa()
    {
        return $this->belongsTo('App\Modulos\Programa\Programa','i_fk_programa');
    }

    public function actividad()
    {
        return $this->belongsTo('App\Modulos\Actividad\Actividad','i_fk_actividad');
    }

    public function tematica()
    {
        return $this->belongsTo('App\Modulos\Tematica\Tematica','i_fk_tematica');
    }

    public function componente()
    {
        return $this->belongsTo('App\Modulos\Componente\Componente','i_fk_tematica');
    }


}
