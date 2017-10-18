<?php

namespace App\Modulos\Usuario;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionPersona extends Model
{
    protected $table = 'configuracionpersona';
	protected $primaryKey = 'i_pk_id';
	protected $fillable = ['i_fk_id_persona','i_id_ambito','i_id_localidad','i_id_tipo_persona'];
	protected $connection = ''; 
	public $timestamps = false;

	public function persona()
    {
        return $this->belongsTo('App\Persona','i_fk_id_persona');
    }

    public function localidad()
    {
	    return $this->belongsTo('App\Localidad', 'i_id_localidad');
    }

}
