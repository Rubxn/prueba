
/**
 * submit form marca
 */
$("#form-marca").submit(function(e) {

    e.preventDefault();

    const form = $(this);
    const url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data)
        {

            if( data.response === 1 ) {
                location.reload();
            } else {
                console.warn(data);
            }

            alert(data.message);

        },
        error: function (error) {

            if (error.responseJSON.status !== 422) {
                let objectErrors = error.responseJSON.errors;
                let campos = Object.values(objectErrors);
                let txt = "";

                campos.forEach(e =>
                    txt = `<li>${e[0]}</li>`
                );

                let errorMarca = $('#form-marca-error');
                errorMarca.html(txt).show(0).delay(5000).hide(0);
            }
        }
    });
});

/**
 * submit form producto
 */
$("#form-producto").submit(function(e) {

    e.preventDefault();

    const form = $(this);
    const url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data)
        {

            if( data.response === 1 ) {
                location.reload();
            } else {
                console.warn(data);
            }

            alert(data.message);

        },
        error: function (error) {

            if (error.responseJSON.status !== 422) {
                let objectErrors = error.responseJSON.errors;
                let campos = Object.values(objectErrors);
                let txt = "";

                campos.forEach(e =>
                    txt = `<li>${e[0]}</li>`
                );

                let errorMarca = $('#form-producto-error');
                errorMarca.html(txt).show(0).delay(5000).hide(0);
            }
        }
    });
});

/**
 * función para eliminar un producto
 * @param id
 */
function eliminarProducto( id ) {
    $.get('/delete/producto/'+id, function (data) {
        alert(data.message);
        if ( data.response === 1 ) { location.reload(); }
    }).fail(function (jqxhr,settings,ex) {
        console.warn(ex);
        alert('Ha ocurrido un error, intentalo de nuevo');
    });
}

/**
 * función para eliminar una marca
 * @param id
 */
function eliminarMarca( id ) {
    $.get('/delete/marca/'+id, function (data) {
        alert(data.message);
        if ( data.response === 1 ) { location.reload(); }
    }).fail(function (jqxhr,settings,ex) {
        console.warn(ex);
        alert('Ha ocurrido un error, intentalo de nuevo');
    });
}

/**
 * función para editar una marca
 * @param id
 */
function editarMarca( id ) {
    $.get('/edit/marca/'+id, function(data){

        $('#nombre-marca').val(data.nombre);
        $('#referencia').val(data.referencia);
        $('#id').val(data.id);

        $('#titleFormMarca').html('Editar Marca');

    }).fail(function (jqxhr,settings,ex) {
        console.warn(ex);
        alert('Ha ocurrido un error, intentalo de nuevo');
    });
}

/**
 * función para editar un producto
 * @param id
 */
function editarProducto( id ) {
    $.get('/edit/producto/'+id, function(data){

        $('#id_producto').val(data.id);
        $('#nombre-producto').val(data.nombre);
        $('#descripcion').val(data.descripcion);
        $('#talla').val(data.talla);
        $('#marca').val(data.marca_id);
        $('#cantidad-inventario').val(data.cantidad_inventario);
        $('#fecha-embarque').val(data.fecha_embarque);
        $('#id').val(data.id);

        $('#titleFormProducto').html('Editar Producto');

    }).fail(function (jqxhr,settings,ex) {
        console.warn(ex);
        alert('Ha ocurrido un error, intentalo de nuevo');
    });
}
