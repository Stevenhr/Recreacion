<?php

namespace App\Modulos\ActividadRecreativa;

use Illuminate\Database\Eloquent\Model;

class ActividadRecreativa extends Model
{
    //
    protected $table = 'actividades';
	protected $primaryKey = 'idActividad';
	protected $fillable = ['idPrograma','actividad','estado'];
	protected $connection = ''; 
	public $timestamps = false;

}
