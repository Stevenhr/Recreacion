<?php

namespace App\Modulos\Tematica;

use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    //
    protected $table = 'Tematica';
	protected $primaryKey = 'IdTematica';
	protected $fillable = ['IdActividad','Tematica','estado'];
	protected $connection = ''; 
	public $timestamps = true;

}
