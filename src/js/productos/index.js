import Swal from 'sweetalert2';
import DataTable from 'datatables.net-bs5';
import { lenguaje } from '../lenguaje';
import { validarFormulario } from '../funciones';

const FormProductos = document.getElementById('FormProductos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

const tablaProductos = new DataTable('#TableProductos', {
    language: lenguaje,
    order: [[3, 'asc'], [4, 'asc']],
    rowGroup: { dataSrc: 'cat_nombre' },
    data: [],
    columns: [
        { title: 'No.', render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Nombre', data: 'pro_nombre' },
        { title: 'Cantidad', data: 'pro_cantidad' },
        { title: 'Categoría', data: 'cat_nombre' }, // nombre de la categoría
        { title: 'Prioridad', data: 'pro_prioridad' },
        {
            title: 'Acciones',
            data: 'pro_id',
            render: (data, type, row) => `
                <div class='d-flex justify-content-center'>
                    <button class='btn btn-success comprar mx-1' data-id='${data}'>
                        <i class="bi bi-check-circle"></i> Comprar
                    </button>
                    <button class='btn btn-warning modificar mx-1'
                        data-id="${data}"
                        data-nombre="${row.pro_nombre}"
                        data-cantidad="${row.pro_cantidad}"
                        data-cat_id="${row.cat_id}"
                        data-prioridad="${row.pro_prioridad}">
                        <i class="bi bi-pencil-square"></i> Modificar
                    </button>
                    <button class='btn btn-danger eliminar mx-1' data-id='${data}'>
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </div>`
        }
    ]
});

const tablaComprados = new DataTable('#TableComprados', {
    language: lenguaje,
    order: [[3, 'asc'], [4, 'asc']],
    rowGroup: { dataSrc: 'cat_nombre' },
    data: [],
    columns: [
        { title: 'Nombre', data: 'pro_nombre' },
        { title: 'Cantidad', data: 'pro_cantidad' },
        { title: 'Categoría', data: 'cat_nombre' },
        { title: 'Prioridad', data: 'pro_prioridad' }
    ]
});

const BuscarProductos = async () => {
    const url = '/app01_jemg/productos/buscarAPI';
    try {
        const respuesta = await fetch(url);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            tablaProductos.clear().rows.add(datos.data).draw();
        } else {
            console.warn('Sin productos pendientes:', datos.mensaje);
        }
    } catch (error) {
        console.error('Error al buscar productos:', error);
    }
};

const BuscarComprados = async () => {
    const url = '/app01_jemg/productos/buscarCompradosAPI';
    try {
        const respuesta = await fetch(url);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            tablaComprados.clear().rows.add(datos.data).draw();
        } else {
            console.warn('Sin productos comprados:', datos.mensaje);
        }
    } catch (error) {
        console.error('Error al buscar productos comprados:', error);
    }
};

const GuardarProducto = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormProductos, ['pro_id'])) {
        Swal.fire("Formulario incompleto", "Todos los campos son obligatorios", "warning");
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);
    const url = '/app01_jemg/productos/guardarAPI';

    try {
        const respuesta = await fetch(url, { method: 'POST', body });
        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            await Swal.fire("¡Éxito!", datos.mensaje, "success");
            limpiarFormulario();
            BuscarProductos();
            BuscarComprados();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (error) {
        console.error('Error al guardar producto:', error);
    }

    BtnGuardar.disabled = false;
};

const ModificarProducto = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormProductos, ['pro_id'])) {
        Swal.fire("Formulario incompleto", "Todos los campos son obligatorios", "warning");
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);
    const url = '/app01_jemg/productos/modificarAPI';

    try {
        const respuesta = await fetch(url, { method: 'POST', body });
        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            await Swal.fire("¡Modificado!", datos.mensaje, "success");
            limpiarFormulario();
            BuscarProductos();
            BuscarComprados();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (error) {
        console.error('Error al modificar producto:', error);
    }

    BtnModificar.disabled = false;
};

const EliminarProducto = async (event) => {
    const id = event.currentTarget.dataset.id;

    const confirmacion = await Swal.fire({
        title: "¿Eliminar producto?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar"
    });

    if (!confirmacion.isConfirmed) return;

    const url = `/app01_jemg/productos/eliminarAPI?id=${id}`;
    try {
        const respuesta = await fetch(url);
        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            Swal.fire("Eliminado", datos.mensaje, "success");
            BuscarProductos();
            BuscarComprados();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (error) {
        console.error("Error al eliminar", error);
    }
};

const ComprarProducto = async (event) => {
    const id = event.currentTarget.dataset.id;
    const url = `/app01_jemg/productos/comprarAPI?id=${id}`;

    try {
        const respuesta = await fetch(url);
        const datos = await respuesta.json();

        if (datos.codigo == 1) {
            Swal.fire("¡Comprado!", datos.mensaje, "success");
            BuscarProductos();
            BuscarComprados();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (error) {
        console.error("Error al marcar como comprado", error);
    }
};

const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset;
    document.getElementById('pro_id').value = datos.id;
    document.getElementById('pro_nombre').value = datos.nombre;
    document.getElementById('pro_cantidad').value = datos.cantidad;
    document.getElementById('cat_id').value = datos.cat_id;
    document.getElementById('pro_prioridad').value = datos.prioridad;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
};

const limpiarFormulario = () => {
    FormProductos.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
};

// Eventos
tablaProductos.on('click', '.modificar', llenarFormulario);
tablaProductos.on('click', '.eliminar', EliminarProducto);
tablaProductos.on('click', '.comprar', ComprarProducto);
FormProductos.addEventListener('submit', GuardarProducto);
BtnModificar.addEventListener('click', ModificarProducto);
BtnLimpiar.addEventListener('click', limpiarFormulario);

// Inicialización
BuscarProductos();
BuscarComprados();
