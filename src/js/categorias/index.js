import Swal from 'sweetalert2';
import {validarFormulario} from '../funciones';
import DataTable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import { event } from 'jquery';


const FormCategorias = document.getElementById('FormCategorias');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

const GuardarCategoria = async (event) => {
    event.preventDefault();  //
    BtnGuardar.disabled = false; //

    const body = new FormData(FormCategorias); //

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

    BtnGuardar.disabled = true

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


FormCategorias.addEventListener('submit', GuardarCategoria);
