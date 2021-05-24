<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{

    protected $table = 'marcas';

    /**
     * Función para registrar nuevas marcas
     * @param $datos
     * @return Marca
     */
    public static function addMarca( $datos ) {

        $marca = new self();
        $marca->referencia  = $datos['referencia'];
        $marca->nombre       = $datos['nombre_marca'];

        $marca->save();

        return $marca;
    }

    /**
     * Función para editar una marca
     * @param $datos
     * @return mixed
     */
    public static function editMarca( $datos ) {

        $marca = self::find($datos['id']);
        $marca->referencia  = $datos['referencia'];
        $marca->nombre       = $datos['nombre_marca'];

        $marca->save();

        return $marca;
    }

    /**
     * Función para eliminar una Marc
     * @param $id
     */
    public static function deleteMarca( $id ):void {
        self::find($id)->delete();
    }

    /**
     * Función para retornar todas las marcas
     * @return Marca[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getMarcas() {
        return self::all()->sortByDesc('id');
    }
}
