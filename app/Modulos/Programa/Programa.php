<?php

namespace App\Modulos\Programa;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    //
    protected $table = 'Programa';
	protected $primaryKey = 'IdPrograma';
	protected $fillable = ['Programa','Descripcion'];
	protected $connection = ''; 
	public $timestamps = true;

}
