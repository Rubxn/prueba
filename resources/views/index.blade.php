<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Catálogo Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <main>
            <div class="py-5 text-center">
                <h2>Catálogo de Productos</h2>
            </div>

            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary" id="test">Marcas</span>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalMarca" onclick="$('#form-marca')[0].reset(); $('#titleFormMarca').html('Registrar Marca'); $('#id_producto').val(0)">+</button>
                    </h4>
                    <ul class="list-group mb-3">
                        @if( $marcas->count() > 0 )
                            @foreach($marcas as $marca)
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">{{ $marca->nombre }}</h6>
                                    <small class="text-muted">REF: {{ $marca->referencia }}</small>
                                </div>
                                <span class="text-muted">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalMarca" onclick="editarMarca({{ $marca->id }})">Editar</button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarMarca({{ $marca->id }})">Eliminar</button>
                                </span>
                            </li>
                            @endforeach
                        @else
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div class="alert alert-danger" role="alert">
                                    No tienes marcas registradas!
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-7 col-lg-8">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Productos</span>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProducto" onclick="$('#form-producto')[0].reset(); $('#titleFormProducto').html('Registrar Producto'); $('#id').val(0)">+</button>
                    </h4>
                    <table class="table caption-top">
                        <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Observacion</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Talla</th>
                            <th scope="col">Stock</th>
                            <th scope="col">F. embarque</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }} </td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>{{ $producto->nombre_marca }}</td>
                                <td style="text-align: center;"><span class="badge bg-info">{{ $producto->talla }}</span></td>
                                <td style="text-align: center;"><span class="badge bg-dark">{{ $producto->cantidad_inventario }}</span></td>
                                <td style="text-align: center;">{{ $producto->fecha_embarque }}</td>
                                <td style="text-align: center;">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalProducto" onclick="editarProducto({{ $producto->id }})">Editar</button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarProducto({{ $producto->id }})">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Marca -->
    <div class="modal fade" id="modalMarca" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="mb-3" id="titleFormMarca">Registrar Marca</h4>
                    <hr>
                    <form method="POST" id="form-marca" action="/marca">
                        @csrf
                        <input type="hidden" id="id" name="id" value="0">

                        <div class="row gy-3">

                            <div class="alert alert-danger" role="alert" id="form-marca-error" style="display: none"></div>

                            <div class="col-12">
                                <label for="nombre-producto" class="form-label">Referencia *</label>
                                <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ingresa un valor numérico" value="{{ old('referencia') }}" required>
                            </div>

                            <div class="col-12">
                                <label for="nombre-producto" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre-marca" name="nombre_marca" placeholder="" value="{{ old('nombre-marca') }}" required>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button form="form-marca" type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Producto -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="mb-3" id="titleFormProducto">Registrar Producto</h4>
                    <hr>
                    <form method="POST" id="form-producto" action="/producto">
                        @csrf
                        <input type="hidden" id="id_producto" name="id" value="0">

                        <div class="row gy-3">
                        <div class="alert alert-danger" role="alert" id="form-producto-error" style="display: none"></div>

                        @if( $marcas->count() === 0 )
                            <div class="alert alert-danger" role="alert">
                                No tienes marcas registradas, debes tener por lo menos una marca para registrar un producto
                            </div>
                        @else
                            <div class="col-12">
                                <label for="nombre-producto" class="form-label">Nombre del producto *</label>
                                <input type="text" class="form-control" id="nombre-producto" name="nombre_producto" placeholder="" value="" required>
                            </div>

                            <div class="col-12">
                                <label for="descripcion" class="form-label">Descripción *</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                            </div>

                            <div class="col-md-2">
                                <label for="talla" class="form-label">Talla *</label>
                                <select class="form-select" id="talla" name="talla" required>
                                    <option value=""></option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="marca" class="form-label">Marca *</label>
                                <select class="form-select" id="marca" name="marca" required>
                                    <option value="">Selecciona</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="cantidad-inventario" class="form-label">Cantidad Inv. *</label>
                                <input type="number" class="form-control" id="cantidad-inventario" name="cantidad_inventario" placeholder="cantidad_inventario" required>
                            </div>

                            <div class="col-md-4">
                                <label for="fecha-embarque" class="form-label">Fecha de Embarque *</label>
                                <input type="date" class="form-control" id="fecha-embarque" name="fecha_embarque" placeholder="" required>
                            </div>
                        @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    @if( $marcas->count() > 0 )
                        <button form="form-producto" type="submit" class="btn btn-success">Guardar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="/js/scripts.js"></script>
</body>
</html>
