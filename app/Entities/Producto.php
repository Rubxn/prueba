<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $table = 'productos';

    public static function addProducto( $datos ) {

        $producto = new self();

        $producto->nombre  = $datos['nombre_producto'];
        $producto->descripcion      = $datos['descripcion'];
        $producto->fecha_embarque   = $datos['fecha_embarque'];
        $producto->marca_id         = $datos['marca'];
        $producto->cantidad_inventario  = $datos['cantidad_inventario'];
        $producto->talla            = $datos['talla'];

        $producto->save();

        return $producto;
    }

    public static function editProducto( $datos ) {

        $producto = self::find($datos['id']);

        $producto->nombre  = $datos['nombre_producto'];
        $producto->descripcion      = $datos['descripcion'];
        $producto->fecha_embarque   = $datos['fecha_embarque'];
        $producto->marca_id            = $datos['marca'];
        $producto->cantidad_inventario  = $datos['cantidad_inventario'];
        $producto->talla            = $datos['talla'];
        $producto->save();

        return $producto;
    }

    public static function deleteProducto( $id ) {

        self::find($id)->delete();
    }

    public static function checkFKMarca( $idMarca ) {
        return self::where('marca_id',$idMarca)->count();
    }

    public static function getProductos() {
        return self::leftJoin('marcas','marcas.id','=','productos.marca_id')
            ->get(['productos.*','marcas.nombre AS nombre_marca','marcas.referencia']);
    }
}
