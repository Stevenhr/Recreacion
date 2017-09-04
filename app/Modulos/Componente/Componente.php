<?php

namespace App\Modulos\Componente;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    //
    protected $table = 'componentes';
	protected $primaryKey = 'idComponente';
	protected $fillable = ['idTematica','componente','estado'];
	protected $connection = ''; 
	public $timestamps = true;

}
