<?php

namespace App\Modulos\CaracteristicaPoblacion;

use Illuminate\Database\Eloquent\Model;

class CaracteristicaPoblacion extends Model
{
    //
    protected $table = 'caracteristicaspoblacion';
	protected $primaryKey = 'i_pk_id';
	protected $fillable = ['tx_caracteristicas','i_estado'];
	protected $connection = ''; 
	public $timestamps = true;

}
