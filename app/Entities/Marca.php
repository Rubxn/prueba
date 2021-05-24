<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{

    protected $table = 'marcas';

    public static function addMarca( $datos ) {

        $marca = new self();
        $marca->referencia  = $datos['referencia'];
        $marca->nombre       = $datos['nombre_marca'];

        $marca->save();

        return $marca;
    }

    public static function editMarca( $datos ) {

        $marca = self::find($datos['id']);
        $marca->referencia  = $datos['referencia'];
        $marca->nombre       = $datos['nombre_marca'];

        $marca->save();

        return $marca;
    }

    public static function deleteMarca( $id ) {

        self::find($id)->delete();
    }
}
