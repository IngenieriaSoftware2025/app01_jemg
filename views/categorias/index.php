<div class="row justify-content-center p-3">
    <div class="col-lg-8">
        <div class="card shadow-lg border-primary">
            <div class="card-body">
                <h4 class="text-center text-primary mb-4">Registrar Categoría</h4>

                <form id="FormCategorias">
                    <input type="hidden" name="cat_id" id="cat_id">

                    <div class="mb-3">
                        <label for="cat_nombre" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="cat_nombre" name="cat_nombre" placeholder="Ej. Alimentos" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success" id="BtnGuardar">Guardar</button>
                        <button type="reset" class="btn btn-secondary">Limpiar</button>
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
<script src="<?= asset('build/js/categorias/index.js') ?>"></script>
