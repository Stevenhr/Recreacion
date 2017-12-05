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

}
