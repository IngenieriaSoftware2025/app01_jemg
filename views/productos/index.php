<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card shadow-lg border-success">
            <div class="card-body">
                <h4 class="text-center text-success mb-4">Registrar Producto</h4>

                <form id="FormProductos">
                    <input type="hidden" id="pro_id" name="pro_id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="pro_nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="pro_nombre" name="pro_nombre" placeholder="Ej. Papel higiénico" required>
                        </div>
                        <div class="col-md-6">
                            <label for="pro_cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="pro_cantidad" name="pro_cantidad" min="1" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cat_id" class="form-label">Categoría</label>
                            <select name="cat_id" id="cat_id" class="form-select" required>
                                <option value="">-- Seleccione una categoría --</option>
                                <?php foreach($categorias as $categoria): ?>
                                    <option value="<?= $categoria->cat_id ?>"><?= $categoria->cat_nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="pro_prioridad" class="form-label">Prioridad</label>
                            <select name="pro_prioridad" id="pro_prioridad" class="form-select" required>
                                <option value="">-- Seleccione prioridad --</option>
                                <option value="Alta">Alta</option>
                                <option value="Media">Media</option>
                                <option value="Baja">Baja</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="pro_comprado" value="0">

                    <div class="row justify-content-center mt-5">
                        <div class="col-auto">
                            <button class="btn btn-success" type="submit" id="BtnGuardar">Guardar</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-warning d-none" type="button" id="BtnModificar">Modificar</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-secondary" type="reset" id="BtnLimpiar">Limpiar</button>
                        </div>
                    </div>
                </form>

                <?php if (!empty($errores)) : ?>
                    <div class="alert alert-danger mt-3">
                        <ul>
                            <?php foreach ($errores as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de productos pendientes -->
<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #198754;">
            <div class="card-body p-3">
                <h3 class="text-center text-success">PRODUCTOS REGISTRADOS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableProductos"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de productos comprados -->
<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow" style="border-radius: 10px; border: 1px solid #6c757d;">
            <div class="card-body p-3">
                <h3 class="text-center text-muted">PRODUCTOS COMPRADOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableComprados"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="<?= asset('build/js/productos/index.js') ?>"></script>
