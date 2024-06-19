<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { AgGridVue } from "ag-grid-vue3";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css";
import Swal from "sweetalert2"; // Optional Theme applied to the grid
import Card from "@/Components/card.vue";
import Tab from "@/Components/Tab.vue";


const pageTitle = "Gestión de Asesor";
const validity = ref(null);
const estateIndicatorsAdviser = ref([]);
const selectIndicatorMoney  = ref([]);
const followUps = ref({});
const columnsTable = [
    { field: 'get_estate.cod_reg', headerName: 'Cod. Regional', filter: true, floatingFilter: true },
    { field: 'get_estate.cod_dep', headerName: 'Cod. Dependencia', filter: true, floatingFilter: true },
    { field: 'get_estate.dependence', headerName: 'Dependencia', filter: true, floatingFilter: true },
    { field: 'get_indicator.name_perspective', headerName: 'Perspectiva', filter: true, floatingFilter: true },
    { field: 'get_indicator.objective_strategy', headerName: 'Obj. Estrategico', filter: true, floatingFilter: true },
    {
        field: 'get_indicator.indicator_strategy',
        headerName: 'Iniciativa Estratégica',
        filter: true,
        floatingFilter: true
    },
    { field: 'goal', headerName: 'Meta', filter: true, floatingFilter: true },
    { field: 'execution_goals', headerName: 'Ejecución', filter: true, floatingFilter: true },
    {
        field: 'percentaje', headerName: 'Porcentaje', filter: true, floatingFilter: true, cellRenderer: (params) => {
            return `${(parseFloat(params.data.execution_goals) / parseFloat(params.data.goal) * 100).toFixed(2)}%`;
        },
    },
    {field: 'physical_recursion', headerName: 'Recurso Físico', filter: true, floatingFilter: true},
    {field: 'technical_recursion', headerName: 'Recurso Técnico', filter: true, floatingFilter: true},
    {field: 'human_resource', headerName: 'Recurso Humano', filter: true, floatingFilter: true},
    {field: 'responsible_indicator', headerName: 'Responsable de Indicador', filter: true, floatingFilter: true},
    {field: 'post_responsible_indicator', headerName: 'Cargo del Responsable', filter: true, floatingFilter: true},
    {field: 'get_indicator.area', headerName: 'Responsable de Indicador', filter: true, floatingFilter: true},
];

const columnsTableAssocMoney = [
    {field: 'get_estate.cod_reg', headerName: 'Regional', filter: true, floatingFilter: true},
    {field: 'get_estate.id', headerName: 'Cod Dependencia', filter: true, floatingFilter: true},
    {field: 'get_estate.dependence', headerName: 'Dependencia', filter: true, floatingFilter: true},
    {field: 'siif', headerName: 'DEP SIIF', filter: true, floatingFilter: true},
    {field: 'project_id', headerName: 'Codigo Proyecto', filter: true, floatingFilter: true},
    {field: 'get_project.project', headerName: 'Proyecto', filter: true, floatingFilter: true},
    {
        field: 'open_money',
        headerName: 'Apertura',
        filter: true,
        floatingFilter: true,
        valueFormatter: p => '$' + formatMoney(p.value),
    },
    {
        field: 'commitment',
        headerName: 'Compromiso',
        filter: true,
        floatingFilter: true,
        valueFormatter: p => '$' + formatMoney(p.value),
    },
    {
        field: 'payments',
        headerName: 'Pagos',
        filter: true,
        floatingFilter: true,
        valueFormatter: p => '$' + formatMoney(p.value),
    },
    {
        field: 'commitment_percentage',
        headerName: 'Porcentaje Comprometido',
        filter: true,
        floatingFilter: true,
        cellRenderer: (params) => {
            return `${parseFloat(params.data.commitment_percentage).toFixed(2)}%`;
        }
    },
    {
        field: 'payment_execution',
        headerName: 'Pago Ejecutado',
        filter: true,
        floatingFilter: true,
        cellRenderer: (params) => {
            return `${parseFloat(params.data.payment_execution).toFixed(2)}%`;
        }
    },
];

const props = defineProps({
    validity: Object
});

const formatMoney = (val) => {
    let number = parseFloat(val);
    if (isNaN(number)) {
        throw new Error('Invalid number');
    }
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};

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
    axios.get('getDataAdviserAssesor', { params: { validity: validity.value } })
        .then((response) => {
            estateIndicatorsAdviser.value = response.data.indicator;
            followUps.value = response.data.followups;
            selectIndicatorMoney.value = response.data.indicatorMoney;
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
            axios.post('updateAdvisorOfficesAssesor', { id: item.id, observation_control: text })
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

const rollBackSave = (item) => {
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
            axios.post('updateFollowUpState', { id: item.id, cicle: 2 })
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
    <AppLayout :title="pageTitle">
        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">{{ pageTitle }}</h1>
        </template>
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-4">
                <h1 class="text-secondary-default font-bold"><i class="fa-regular fa-calendar-days"></i> Vigencia</h1>
                <select class="rounded-md" name="viability" id="viability" v-model="validity">
                    <option value="" disabled selected>Seleccione el año</option>
                    <option :value="via.id" v-for="via in props.validity" :key="via.id">{{ via.validity }}</option>
                </select>
                <button @click="consult"
                    class="transition-all w-fit text-white px-4 py-2 bg-secondary-default rounded-md hover:bg-primary-default hover:scale-105">
                    Validar
                </button>
            </div>
        </div>

        <div class="rounded-md shadow overflow-x-auto">
            <table class="table-auto w-full">
                <thead class="bg-secondary-default text-white">
                    <tr>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-hashtag"></i> Cod Dependencia</th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-file-lines"></i> Justificación de Indicadores</th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-file-invoice-dollar"></i> Justificación Presupuestal</th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-regular fa-calendar-days"></i> Fecha</th>
                        <th class="py-3 px-6 text-left">Justificación de Seguimiento</th>
                        <th class="py-3 px-6 text-left">Asesor</th>
                    </tr>
                </thead>
                <tbody class="divide-y-4 divide-white text-gray-600 text-sm font-light">
                    <tr class="divide-x-4 divide-white" v-for="item in followUps" :key="item.id" :class="{ 'bg-gray-100': item.status === 'Activo' }">
                        <td class="bg-gray-200 px-4 py-3">
                            <div class="grid grid-cols-1">
                                <div>
                                    {{ item.estate_id }} / {{item.get_estate_only.dependence}}
                                </div>

                                <a :href="`export/followup/dep?id=${item.id}&relation=${item.status === 'Activo' ? 0 : 1 }`" class="bg-green-600 text-white w-12 h-12 flex items-center justify-center rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                                    <i class="fas fa-file-excel"></i>
                                </a>
                                <span v-if="item.status != 'Activo'" class="bg-red-100 text-red-700 px-4 py-2 rounded font-thin text-xs">
                                      Seguimento Cerrado
                                </span>
                            </div>

                        </td>
                        <td class="bg-gray-100 px-4 py-3">
                            {{ item.justify_estate_indicator }}
                        </td>
                        <td class="bg-gray-200 px-4 py-3">{{ item.justify_estate_money }}
                        </td>
                        <td class="bg-gray-100 px-4 py-3">{{ formatDate(item.created_at) }}
                        </td>
                        <td class="bg-gray-200 px-4 py-3">{{ item.observation_control }}
                        </td>
                        <td class="bg-gray-100 px-4 py-3">
                            <div class="flex">
                                <button v-if="item.status == 'Activo' && item.cicle == 3" @click="rollBackSave(item)" class="ml-3 inline-flex items-center px-4 py-2 bg-secondary-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    No Validar
                                </button>

                            </div>

                        </td>
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

        <card class="w-full">
            <div class="w-full mt-4 bg-white p-3 rounded-lg "
                v-if="$page.props.auth.user.role_id != 2 && Object.keys(estateIndicatorsAdviser).length > 0">
                <div class="grid grid-cols-1 gap-2">
                    <tab>
                        <template #t1>
                            <ag-grid-vue :rowData="estateIndicatorsAdviser" :columnDefs="columnsTable" style=""
                                         class="ag-theme-quartz h-96" rowSelection="multiple" @selection-changed="onSelectionChanged"
                                         @grid-ready="onGridReady">
                            </ag-grid-vue>
                        </template>
                        <template #t2>
                            <div class="ag-grid-section px-2 mb-6">
                                <ag-grid-vue
                                    :rowData="selectIndicatorMoney"
                                    :columnDefs="columnsTableAssocMoney"
                                    class="ag-theme-quartz h-96"
                                    rowSelection="multiple"
                                    @selection-changed="onSelectionChanged"
                                    @grid-ready="onGridReady"
                                    :columnHoverHighlight="true"
                                >
                                </ag-grid-vue>
                            </div>
                        </template>
                    </tab>

                </div>
            </div>
        </card>
    </AppLayout>
</template>
