<h4 class="mb-3">Editar Marca</h4>
<hr>
<form method="POST" id="form-marca" action="/crear-marca">
    @csrf
    <input type="hidden" id="id" name="id" value="{{ $marca->id }}">

    <div class="row gy-3">

        <div class="alert alert-danger" role="alert" id="form-marca-error" style="display: none">
        </div>

        <div class="col-12">
            <label for="nombre-producto" class="form-label">Referenciasss *</label>
            <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ingresa un valor numérico" value="{{ $marca->referencia }}" required>
        </div>

        <div class="col-12">
            <label for="nombre-producto" class="form-label">Nombre *</label>
            <input type="text" class="form-control" id="nombre-marca" name="nombre_marca" placeholder="" value="{{ $marca->nombre }}" required>
        </div>

    </div>
</form>
