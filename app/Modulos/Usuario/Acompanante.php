<?php

namespace App\Modulos\Usuario;

use Illuminate\Database\Eloquent\Model;

class Acompanante extends Model
{
    //
    protected $table = 'acompanantes';
	protected $primaryKey = 'i_pk_id';
	protected $fillable = ['i_fk_id_actividad','i_fk_usuario','tx_observacion'];
	protected $connection = ''; 
	public $timestamps = true;

}
