<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenida María! Aquí podés gestionar tu lista de compras</h5>
                    <h4 class="text-center mb-2 text-primary">GESTIÓN DE PRODUCTOS</h4>
                </div>

                <div class="row justify-content-center p-4 shadow-lg">
                    <form id="FormProductos">
                        <input type="hidden" id="pro_id" name="pro_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="pro_nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="pro_nombre" name="pro_nombre" placeholder="Ej. Papel higiénico">
                            </div>
                            <div class="col-lg-6">
                                <label for="pro_cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="pro_cantidad" name="pro_cantidad" min="1" placeholder="Ej. 3">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="cat_id" class="form-label">Categoría</label>
                                <select name="cat_id" class="form-select" id="cat_id" required>
                                    <option value="">-- Seleccione una categoría --</option>
                                    <?php foreach($categorias as $categoria): ?>
                                        <option value="<?= $categoria->cat_id ?>"><?= $categoria->cat_nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="pri_id" class="form-label">Prioridad</label>
                                <select name="pri_id" class="form-select" id="pri_id" required>
                                    <option value="">-- Seleccione una prioridad --</option>
                                    <?php foreach($prioridades as $prioridad): ?>
                                        <option value="<?= $prioridad->pri_id ?>"><?= $prioridad->pri_nivel ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Estado de compra (oculto por defecto) -->
                        <input type="hidden" name="pro_comprado" id="pro_comprado" value="0">

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    Guardar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                    Modificar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    Limpiar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de productos registrados -->
<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">PRODUCTOS REGISTRADOS</h3>
                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableProductos">
                        <!-- Contenido generado por JS -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/productos/index.js') ?>"></script>
