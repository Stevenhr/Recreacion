<?php

namespace App;

use Idrd\Usuarios\Repo\Persona as MPersona;

class Persona extends MPersona
{
    public function configuraciones() {
        return $this->hasMany('App\Modulos\Usuario\ConfiguracionPersona', 'i_fk_id_persona');
    }
}
