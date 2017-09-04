<?php

namespace App\Modulos\Programa;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    //
    protected $table = 'programas';
	protected $primaryKey = 'idPrograma';
	protected $fillable = ['programa','descripcion'];
	protected $connection = ''; 
	public $timestamps = true;

}
