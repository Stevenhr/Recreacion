<?php

namespace App\Modulos\Configuracion;


class Configuracion
{
    const PENDIENTE = 0; 
    const APROBADO = 1;
    const DEVUELTO = 2; //Estado para devolver con observaciones para su arreglo. Eje. Devolver visita le permite al interventor modificar la visita. 
    const CANCELADO = 3; // No se permite modificar nada cuando este cancelado. 

	const RESPOSANBLE_ACTIVIDAD = 1; // Solo una localidad, Recreador encargado de ejecutar la actividad
    const  GESTOR = 2; // Varias localidades, persona encargada de crear la actividad y asignarcela a un RESPOSANBLE_ACTIVIDAD
    const RESPOSANBLE_PROGRAMA = 3; // Persona encargada de aprobar la actividad creada por el GESTOR
    const OBSERVADOR = 4; // Da observaciones a todas las actividades.
    const ADMINISTRADOR = 5; // Administrador de sistema
    

    public static function getArrayForSelect()
    {
        return [
          self::PENDIENTE   =>  self::toString(self::PENDIENTE),
          self::APROBADO    =>  self::toString(self::APROBADO),
          self::DEVUELTO    =>  self::toString(self::DEVUELTO),
          self::CANCELADO   =>  self::toString(self::CANCELADO),
        ];
    }

    static function toString($codigo)
    {
        $estado = '';
        switch ($codigo) {
            case 0:
                $estado = 'Pendiente de revisión.';
            break;
            case 1:
                $estado = 'Aprobado';
            break;
            case 2:
                $estado = 'Devuelto';
            break;
            case 3:
                $estado = 'Cancelado';
            break;
            default:
                $estado = 'otra';
            break;
        }

        return $estado;
    }
}