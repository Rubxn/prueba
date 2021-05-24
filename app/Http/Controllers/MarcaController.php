<?php

namespace App\Http\Controllers;

use App\Entities\Marca;
use App\Entities\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View, Input;

class MarcaController extends BaseController
{

    /**
     * @param string $acc
     * @param string $type
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index($acc = 'list', $type = '', $id = 0)
    {

        $this->_data['marcas']      = Marca::all()->sortByDesc('id');
        $this->_data['productos']   = Producto::leftJoin('marcas','marcas.id','=','productos.marca_id')
                                                ->get(['productos.*','marcas.nombre AS nombre_marca','marcas.referencia']);
        $this->_data['acc'] = $acc;

        if ( $acc == 'delete' && $id > 0 ) {

            $result = ['response' => 1, 'message' => 'Registro eliminado exitosamente'];

            if ( $type == 'marca' ) {

                $marca      = Marca::find($id);
                $validarFK  = Producto::checkFKMarca( $id );

                if ( $validarFK > 0 ) {
                    $result = ['response' => 0, 'message' => "Eliminar primero los productos con la marca $marca->nombre"];
                } else {
                    Marca::deleteMarca($id);
                }
            }

            if ( $type == 'producto' ) {
                Producto::deleteProducto($id);
            }

            return response()->json($result);
        }

        if ( $acc == 'edit' && $id > 0 ) {

            if ( $type == 'marca' ) {
                $datos = Marca::find($id);
            }

            if ( $type == 'producto' ) {
                $datos = Producto::find($id);
            }

            return response()->json($datos);
        }

        return View('index', $this->_data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Marca( Request $request )
    {

        // Validamos en el BaseController los campos del formulario, en caso de no cumplir las reglas retorna error
        $this->validator('marcas', $request->all(), $request->get('id') > 0 ? true : false )->validate();

        try {

            if ( $request->get('id') > 0 ) {
                $marca = Marca::editMarca($request->all());
            } else {
                // Registramos la nueva marca
                $marca = Marca::addMarca($request->all());
            }

            if ( $marca->id > 0 ) {
                $result = ['response' => 1, 'message' => "La marca $marca->nombre ha sido registrada exitosamente."];
            } else {
                $result = ['response' => 1, 'message' => "Ha ocurrido un error, intentalo de nuevo"];
            }

        } catch ( \Exception $e ) {
            $result = ['response' => 0, 'message' => 'Ha ocurrido un error, intentalo de nuevo', 'log' => $e];
        }

        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Producto( Request $request )
    {

        // Validamos en el BaseController los campos del formulario, en caso de no cumplir las reglas retorna error
        $this->validator('productos', $request->all(), $request->get('id') > 0 ? true : false )->validate();

        try {

            if ( $request->get('id') > 0 ) {
                $producto = Producto::editProducto($request->all());
            } else {
                // Registramos la nueva marca
                $producto = Producto::addProducto($request->all());
            }

            if ( $producto->id > 0 ) {
                $result = ['response' => 1, 'message' => "El producto ha sido registrado exitosamente."];
            } else {
                $result = ['response' => 1, 'message' => "Ha ocurrido un error, intentalo de nuevo"];
            }

        } catch ( \Exception $e ) {
            $result = ['response' => 0, 'message' => 'Ha ocurrido un error, intentalo de nuevo', 'log' => $e];
        }

        return response()->json($result);
    }
}
