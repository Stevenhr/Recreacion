<?php

namespace App\Modulos\ActividadRecreativa;

use Illuminate\Database\Eloquent\Model;

class ActividadRecreativa extends Model
{
    //
    protected $table = 'Actividad';
	protected $primaryKey = 'IdActividad';
	protected $fillable = ['IdPrograma','Actividad'];
	protected $connection = ''; 
	public $timestamps = false;

}
