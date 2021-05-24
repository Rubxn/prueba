<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BaseController extends Controller
{
    protected $_data = [];

    protected function validator( $table, array $data, $updating = false )
    {

        $validation = '';
        $messages = [
            'required'  => 'El campo :attribute es obligatorio.',
            'integer'   => 'El campo :attribute debe ser numérico.',
            'unique'    => 'El campo :attribute ya existe en otro registro.',
            'min'      => 'El campo :attribute debe ser mayor o igual :min',
            'max'      => 'El campo :attribute solo permite un máximo de :max caracteres',
        ];

        switch ( $table ) {
            case 'marcas':

                if ( $updating === false ) {
                    $validate = ['required', 'integer', 'min:1','unique:marcas,referencia'];
                } else {
                    $validate = ['required', 'integer', 'min:1','unique:marcas,referencia,'.$data['id']];
                }


                $validation =  Validator::make($data, [
                    'referencia'            => $validate,
                    'nombre_marca'          => ['required', 'string', 'max:100'],
                ],$messages);
            break;

            case 'productos':

                $validation =  Validator::make($data, [
                    'nombre_producto'      => ['required', 'string', 'min:2','max:100'],
                    'descripcion'          => ['required', 'max:256'],
                    'talla'                => ['required', ],
                    'marca'                => ['required','integer'],
                    'cantidad_inventario'  => ['required','integer','min:0'],
                    'fecha_embarque'       => ['required','date'],
                ],$messages);
            break;
        }

        return $validation;
    }

}
