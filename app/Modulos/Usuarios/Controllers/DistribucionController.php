<?php

namespace App\Modulos\Usuarios\Controllers;

use App\Http\Controllers\Controller;
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


        return view('idrd.usuarios.distribuir');
    }
}