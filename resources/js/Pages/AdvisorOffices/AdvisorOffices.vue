<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from "vue";
import {AgGridVue} from "ag-grid-vue3";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css";
import Swal from "sweetalert2"; // Optional Theme applied to the grid

const validity = ref(null);
const estateIndicatorsAdviser = ref([]);
const followUps = ref({});
const columnsTable = [
    {field: 'get_estate.cod_reg', headerName: 'Cod. Regional', filter: true, floatingFilter: true},
    {field: 'get_estate.cod_dep', headerName: 'Cod. Dependencia', filter: true, floatingFilter: true},
    {field: 'get_estate.id', headerName: 'Cod. Dependencia', filter: true, floatingFilter: true},
    {field: 'get_indicator.name_indicator', headerName: 'Dependencia', filter: true, floatingFilter: true},
    {field: 'get_indicator.name_perspective', headerName: 'Perspectiva', filter: true, floatingFilter: true},
    {field: 'get_indicator.name_strategy', headerName: 'Nom. Estrategico', filter: true, floatingFilter: true},
    {
        field: 'get_indicator.name_indicator_strategy',
        headerName: 'Indicador Estrategico',
        filter: true,
        floatingFilter: true
    },
    {field: 'goal', headerName: 'Meta', filter: true, floatingFilter: true},
    {field: 'execution_goals', headerName: 'Ejecución Meta', filter: true, floatingFilter: true},
    {
        field: 'percentaje', headerName: 'Porcentaje', filter: true, floatingFilter: true, cellRenderer: (params) => {
            return (parseFloat(params.data.execution_goals) / parseFloat(params.data.goal) * 100).toFixed(2);
        }
    },
    {field: 'status', headerName: 'Estado', filter: true, floatingFilter: true},
];

const props = defineProps({
    validity: Object
});


const formatDate = (setDate) => {
    let fechaObjeto = new Date(setDate);
    let año = fechaObjeto.getFullYear();
    let mes = fechaObjeto.getMonth() + 1; // Se suma 1 porque los meses van de 0 a 11 en JavaScript
    let dia = fechaObjeto.getDate();
    let hora = fechaObjeto.getHours();
    let minutos = fechaObjeto.getMinutes();
    let segundos = fechaObjeto.getSeconds();

// Formatear el resultado como "año-mes-día hora:minutos:segundos"
    let formato = `${año}-${mes < 10 ? '0' + mes : mes}-${dia < 10 ? '0' + dia : dia} ${hora < 10 ? '0' + hora : hora}:${minutos < 10 ? '0' + minutos : minutos}:${segundos < 10 ? '0' + segundos : segundos}`;
    return formato;
}
const consult = () => {
    axios.get('getDataAdviserAssesor', {params: {validity: validity.value}})
        .then((response) => {
            estateIndicatorsAdviser.value = response.data.indicator;
            followUps.value = response.data.followups;
        });
}

const update = (item) => {
    const text = document.getElementById("updateJustify" + item.id).value;
    if (text.length == 0) {
        Swal.fire({
            title: 'Error',
            text: 'Los Campos son Obligatorios',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Cerrar',
            target: "#justifyForModal"
        });
        return 0;
    }
    Swal.fire({
        title: "Aviso Importante?",
        text: "Está usted Seguro!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si!",
        cancelButtonText: "Cancelar",
        target: "#justifyForModal"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post('updateAdvisorOfficesAssesor', {id: item.id, observation_control: text})
                .then((response) => {
                    consult();
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Se ha actualizado correctamente: ',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar',
                        target: "#justifyForModal"
                    })
                });
        }
    });
}
</script>
<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">Gestión de Asesor</h1>
        </template>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex flex-col gap-4">
                <div class="flex items-center py-2">
                    <span class="flex items-center mr-2 bg-secondary-default px-3 py-1 rounded-lg text-white"><img
                        src="/assets/images/vigencia.webp" alt="" width="35px">Vigencia</span>
                    <select
                        class="block w-40 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        name="viability" id="viability" v-model="validity">
                        <option :value="via.id" v-for="via in props.validity" :key="via.id">{{ via.validity }}</option>
                    </select>
                    <button @click="consult"
                            class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Validar
                    </button>
                </div>
            </div>


            <div class="mt-3 rounded-md shadow overflow-x-auto">
                <div>
                    <table class="table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Cod Dependencia</th>
                            <th class="py-3 px-6 text-left">Justificación de Indicadores</th>
                            <th class="py-3 px-6 text-left">Justificación Presupuestal</th>
                            <th class="py-3 px-6 text-left">Fecha</th>
                            <th class="py-3 px-6 text-left">Justificación de Seguimiento</th>
                            <!--<th class="py-3 px-6 text-left">Asesor</th>-->
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr v-for="item in followUps" :key="item.id"
                            :class="{ 'bg-gray-100': item.status === 'Activo' }">
                            <td class="p-2 border border-gray-300 rounded-md bg-white">{{ item.estate_id }}</td>
                            <td class="p-2 border border-gray-300 rounded-md bg-white">{{ item.justify_estate_indicator }}</td>
                            <td class="p-2 border border-gray-300 rounded-md bg-white">{{ item.justify_estate_money }}</td>
                            <td class="p-2 border border-gray-300 rounded-md bg-white">{{ formatDate(item.created_at) }}</td>
                            <td class="p-2 border border-gray-300 rounded-md bg-white">{{ item.observation_control }}</td>
                            <!--<td class="py-3 px-6 text-left" v-if="item.assesor == null">
                                <div class="grid grid-cols-1 gap-3">
                                    <textarea :name="`updateJustify`+item.id" :id="`updateJustify`+item.id" cols="60"
                                              rows="8" class="w-full px-3 py-2 border rounded-md"></textarea>
                                    <button @click="update(item)"
                                            class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        Guardar
                                    </button>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left" v-else>
                                {{ item.assesor }}
                            </td>-->
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="w-full mt-4"
                 v-if="$page.props.auth.user.role_id != 2 && Object.keys(estateIndicatorsAdviser).length > 0">
                Indicadores
                <div class="grid grid-cols-1 gap-2">
                    <ag-grid-vue
                        :rowData="estateIndicatorsAdviser"
                        :columnDefs="columnsTable"
                        style=""
                        class="ag-theme-quartz h-screen"
                        rowSelection="multiple"
                        @selection-changed="onSelectionChanged"
                        @grid-ready="onGridReady"
                    >
                    </ag-grid-vue>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
