<?php

namespace App\Modulos\Componente;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    //
    protected $table = 'Componenete';
	protected $primaryKey = 'IdComponente';
	protected $fillable = ['IdTematica','Component'];
	protected $connection = ''; 
	public $timestamps = true;

}
