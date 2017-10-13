<?php

namespace App\Modulos\Actividad;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    //
    protected $table = 'actividades';
	protected $primaryKey = 'idActividad';
	protected $fillable = ['idPrograma','actividad','estado'];
	protected $connection = ''; 
	public $timestamps = true;

}
