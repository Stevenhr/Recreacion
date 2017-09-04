<?php

namespace App\Modulos\Tematica;

use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    //
    protected $table = 'tematicas';
	protected $primaryKey = 'idTematica';
	protected $fillable = ['idActividad','tematica','estado'];
	protected $connection = ''; 
	public $timestamps = true;

}
