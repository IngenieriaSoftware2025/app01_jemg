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

<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">CATEGORIAS REGISTRADAS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableCategorias">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/categorias/index.js') ?>"></script>
