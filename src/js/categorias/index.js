import Swal from 'sweetalert2';
import {validarFormulario} from '../funciones';
import DataTable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";


const FormCategorias = document.getElementById('FormCategorias');
const cat_nombre = document.getElementById('cat_nombre');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

const validarNombre = () => {
    const nombre = cat_nombre.value.trim();
    if (nombre === "") {
        Swal.fire({
            icon: "warning",
            title: "Campo vacío",
            text: "El nombre de la categoría es obligatorio"
        });
    }
};

const GuardarCategoria = async (event) => {
    event.preventDefault();  
    BtnGuardar.disabled = true; 

    const body = new FormData(FormCategorias); 

    const url = '/app01_jemg/categorias/guardarAPI';
    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch (url, config);
        const datos = await respuesta.json();

        const{ codigo, mensaje } = datos;

        if (codigo == 1){
            await Swal.fire({
                icon: "success",
                title: "Éxito",
                text: mensaje
            });
            FormCategorias.reset();
        }else {
            await Swal.fire({
                icon: "error",
                title: "Error",
                text: mensaje
            });
        }
    } catch (error) {
        console.log(error);        
    }

    BtnGuardar.disabled = false

};

const BuscarCategorias = async () => {
    const url = '/app01_jemg/categorias/buscarAPI';
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            datatable.clear().draw();
            datatable.rows.add(data).draw();

        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error);
    }
};

const datatable = new DataTable('#TableCategorias', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {
            title: 'No.',
            data: 'cat_id',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Nombre', data: 'cat_nombre' },
        {
            title: 'Situación',
            data: 'cat_situacion',
            render: (data) => data === 1 ? 'Activa' : 'Inactiva'
        },
        {
            title: 'Acciones',
            data: 'cat_id',
            searchable: false,
            orderable: false,
            render: (data, type, row) => {
                return `
                    <div class='d-flex justify-content-center'>
                        <button class='btn btn-warning modificar mx-1' 
                            data-id="${data}" 
                            data-nombre="${row.cat_nombre}"  
                            data-situacion="${row.cat_situacion}">
                            <i class='bi bi-pencil-square me-1'></i>Modificar
                        </button>
                        <button class='btn btn-danger eliminar mx-1' 
                            data-id="${data}">
                            <i class="bi bi-trash3 me-1"></i>Eliminar
                        </button>
                    </div>`;
            }
        }
    ]
});

const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset;

    document.getElementById('cat_id').value = datos.id;
    document.getElementById('cat_nombre').value = datos.nombre;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
};

const limpiarTodo = () => {
    FormCategorias.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
};

const ModificarCategoria = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormCategorias, [''])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormCategorias);

    const url = '/app01_jemg/categorias/modificarAPI';
    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarCategorias();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.error(error);
    }

    BtnModificar.disabled = false;
};

const eliminarCategoria = async (event) => {
    const id = event.currentTarget.dataset.id;

    const confirmacion = await Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esto eliminará la categoría',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (!confirmacion.isConfirmed) return;

    const url = `/app01_jemg/categorias/eliminarAPI?id=${id}`;
    const config = { method: 'GET' };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();

        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire("Eliminado", mensaje, "success");
            BuscarCategorias();
        } else {
            Swal.fire("Error", mensaje, "error");
        }
    } catch (error) {
        console.error(error);
    }
};

BuscarCategorias();

datatable.on('click', '.modificar', llenarFormulario);
FormCategorias.addEventListener('submit', GuardarCategoria);
cat_nombre.addEventListener('change', validarNombre);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarCategoria);
datatable.on('click', '.eliminar', eliminarCategoria);
