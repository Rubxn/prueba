<?php

namespace App\Http\Controllers;

use App\Entities\Marca;
use App\Entities\Producto;
use Illuminate\Http\Request;
use View, Input;

class MaestroController extends BaseController
{

    /**
     * @param string $acc
     * @param string $type
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(string $acc = 'list', string $type = '', int $id = 0)
    {

        $this->_data['marcas']      = Marca::getMarcas();
        $this->_data['productos']   = Producto::getProductos();
        $this->_data['acc']         = $acc;

        //Valido si el parametro acción es eliminar y recibo un ID
        if ( $acc == 'delete' && $id > 0 ) {

            $result = ['response' => 1, 'message' => 'Registro eliminado exitosamente'];

            // En caso de eliminar una marca
            if ( $type == 'marca' ) {

                // Consulto si existe la marca
                $marca      = Marca::find($id);
                // Verifico si la marca está registrada en un producto
                $validarFK  = Producto::checkFKMarca( $id );

                if ( $validarFK > 0 ) {
                    $result = ['response' => 0, 'message' => "Eliminar primero los productos con la marca $marca->nombre"];
                } else {
                    Marca::deleteMarca($id);
                }
            }

            // En caso de eliminar una marca
            if ( $type == 'producto' ) {
                Producto::deleteProducto($id);
            }

            return response()->json($result);
        }

        // Valido si me piden editar
        if ( $acc == 'edit' && $id > 0 ) {

            if ( $type == 'marca' )     { $datos = Marca::find($id); }
            if ( $type == 'producto' )  { $datos = Producto::find($id); }

            return response()->json($datos);
        }

        return View('index', $this->_data);
    }

    /**
     * Método para registrar/actualizar información de las marcas
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
     * Método para registrar/actualizar productos
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Producto( Request $request )
    {

        // Validamos en el BaseController los campos del formulario, en caso de no cumplir las reglas retorna error
        $this->validator('productos', $request->all(), $request->get('id') > 0 ? true : false )->validate();

        try {

            // Verifico si del recibo del form un id
            if ( $request->get('id') > 0 ) {
                // Actualizo el producto
                $producto = Producto::editProducto($request->all());
            } else {
                // Registramos el producto
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
