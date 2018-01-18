<?php

namespace App\Modulos\CaracteristicaPoblacion;

use Illuminate\Database\Eloquent\Model;

class Elementoscaracteristicas extends Model
{
    //
    protected $table = 'elementoscaracteristicas';
	protected $primaryKey = 'i_pk_id';
	protected $fillable = ['vc_elemento','i_fk_id_carac','i_estado'];
	protected $connection = ''; 
	public $timestamps = true;

	public function caracteristicaPoblacion()
    {
        return $this->belongsTo('App\Modulos\CaracteristicaPoblacion\CaracteristicaPoblacion','i_fk_id_carac');
    }

}
