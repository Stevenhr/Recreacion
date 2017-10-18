<?php

namespace App;

use Idrd\Usuarios\Repo\Localidad as MLocalidad;

class Localidad extends MLocalidad
{
    public function configuraciones()
    {
        return $this->hasMany('App\Modulos\Usuario\ConfiguracionPersona', 'i_fk_id_persona');
    }
}