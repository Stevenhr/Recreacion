<?php

namespace App\Modulos\Usuario\Controllers;

use App\Http\Controllers\Controller;
use App\Localidad;
use App\Modulos\Configuracion\Configuracion;
use App\Modulos\Usuario\ConfiguracionPersona;
use App\Persona;
use Idrd\Usuarios\Repo\PersonaInterface;
use Illuminate\Http\Request;

class DistribucionController extends Controller {

    protected $Usuario;
    protected $repositorio_personas;

    public function __construct(PersonaInterface $repositorio_personas)
    {
        if (isset($_SESSION['Usuario']))
            $this->Usuario = $_SESSION['Usuario'];

        $this->repositorio_personas = $repositorio_personas;
    }

    public function index()
    {
        $data = [
            'perfiles' => Configuracion::getPerfilesForSelect(),
            'localidades' => Localidad::all()
        ];

        return view('idrd.usuarios.distribuir', $data);
    }

    public function asignarRol(Request $request)
    {

    }

    public function cargarRol(Request $request)
    {
        ConfiguracionPersona::where('id_persona', $request->input('id_persona'));
    }
}