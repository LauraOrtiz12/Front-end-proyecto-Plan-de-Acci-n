<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from 'vue';
import {router} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import JusitfyEstateValidity from "@/Pages/Validate/JusitfyEstateValidity.vue";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import {AgGridVue} from "ag-grid-vue3";

defineProps({
    followUp: Object,
    viability: Object,
    estates: Object,
    estatesControl: Object
});

const validity = ref('');
const estateIndicators = ref([]);
const estateIndicatorsAdviser = ref([]);
const followUp = ref({});
const showModalJustifyOne = ref(false);
const cicle = ref(1);
const selectSaveJustify = ref(0);
const selectFollow = ref({});
const gridApi = ref();

const columnsTable = [

    {field: 'get_indicator.name_indicator', headerName: 'Indicador', filter: true, floatingFilter: true},
    {field: 'get_indicator.id', headerName: 'Cod. Indicador', filter: true, floatingFilter: true},
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

const loadViabilityControl = () => {
    axios.get('estateIndicatorsAdviser', {params: {validity: validity.value}})
        .then((response) => estateIndicatorsAdviser.value = response.data)

    axios.get('estateIndicators', {params: {validity: validity.value}})
        .then((response) => estateIndicators.value = response.data);

    axios.get('getFollowUp', {params: {validity: validity.value}})
        .then((response) => followUp.value = response.data);
}

const goJustify = (item) => {
    router.get('justify/indicator', item)
}

const openJustifyOne = (select) => {
    selectFollow.value = select;
    showModalJustifyOne.value = !showModalJustifyOne.value;
}
const closeJustifyOne = () => {
    loadViabilityControl();
    showModalJustifyOne.value = !showModalJustifyOne.value;
}

const onGridReady = (params) => {
    gridApi.value = params.api;
}
const onBtExport = () => {

    gridApi.value.exportDataAsCsv({columnSeparator: "&"});
}
</script>
<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">Validar Vigencia</h1>
        </template>
        <div class="flex flex-col gap-4">
            <div class="flex items-center">
                <span class="flex items-center mr-2 bg-secondary-default px-3 py-1 rounded-lg text-white"><img
                    src="assets/images/vigencia.webp" alt="" width="35px">Vigencia</span>
                <select
                    class="block w-40 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    name="viability" id="viability" v-model="validity">
                    <option :value="via.id" v-for="via in viability" :key="via.id">{{ via.validity }}</option>
                </select>
                <button @click="loadViabilityControl"
                        class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        v-if="Object.keys($page.props.estatesControl).length > 0 || Object.keys($page.props.estates).length > 0">
                    Validar
                </button>
            </div>
            <div class="flex flex-wrap lg:flex-nowrap gap-3 shadow p-3 rounded-md bg-white"
                 v-if="$page.props.auth.user.role_id != 1 && Object.keys($page.props.estates).length > 0">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Información de la Propiedad</h3>
                    <p class="text-sm text-gray-500">Detalles de la propiedad seleccionada</p>
                </div>
                <dl class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Código de Regional:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ estates.cod_reg }}</dd>
                    </div>
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Código de Dependencia:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ estates.cod_dep }}</dd>
                    </div>
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Dependencia:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ estates.dependence }}</dd>
                    </div>
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Responsable de Seguimiento:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ estates.get_adviser.name }} - Correo: {{
                                estates.get_adviser.email
                            }}
                        </dd>
                    </div>

                    <div v-for="(fup, index) in followUp" class="col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                                <dt class="text-sm font-medium text-gray-800">Estado de Proceso:</dt>
                                <dd class="mt-1 text-sm text-gray-500 sm:col-span-2 font-weight-bold">
                                    <div v-if="fup.cicle == 1">
                                        En Dependencia
                                    </div>
                                    <div v-if="fup.cicle == 2">
                                        En Seguimiento
                                    </div>
                                    <div v-if="fup.cicle == 3">
                                        En Seguimiento / Dirección General
                                    </div>
                                </dd>
                            </div>
                            <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                                <dt class="text-sm font-medium text-gray-800"></dt>
                                <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">
                                    <button @click="openJustifyOne(fup)" v-if="fup.cicle == 1"
                                            class="hover:bg-primary-default hover:text-white text-primary-default border border-primary-default font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline block">
                                        Justificar x Dependencia ({{ fup.month }})
                                    </button>
                                </dd>
                            </div>
                        </div>
                    </div>
                </dl>
            </div>
            <div v-else class="text-center bg-white mt-1">
                <span>No Tiene Asociado una dependencia</span>
            </div>
            <div class="mt-3 rounded-md shadow overflow-x-auto"
                 v-if="$page.props.auth.user.role_id != 1 && Object.keys(estateIndicators).length > 0">


                <div class="mt-3 rounded-md shadow overflow-x-auto"
                     v-if="$page.props.auth.user.role_id != 1 && Object.keys(estateIndicators).length > 0">

                    <div class="w-full py-4 my-4" v-for="(fupTwo, indexTwo) in followUp" :key="indexTwo">
                        <div v-if="fupTwo.cicle == 2 || fupTwo.cicle == 3"
                             class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-gray-200 p-4 bg-white rounded-md">
                            <div class="md:col-span-3 mb-2">
                                <span class="font-bold text-lg">Justificaciones En Proceso</span>
                            </div>
                            <div class="md:col-span-3 mb-2">
                                <span class="font-semibold">Mes de Seguimiento: </span>{{ fupTwo.month }}
                            </div>
                            <div class="p-2 border border-gray-300 rounded-md bg-white">
                                <span class="font-semibold block">Indicadores:</span>
                                <span>{{ fupTwo.justify_estate_indicator }}</span>
                            </div>
                            <div class="p-2 border border-gray-300 rounded-md bg-white">
                                <span class="font-semibold block">Presupuesto:</span>
                                <span>{{ fupTwo.justify_estate_money }}</span>
                            </div>
                            <div class="p-2 border border-gray-300 rounded-md bg-white">
                                <span class="font-semibold block">Observación:</span>
                                <span>{{ fupTwo.observation_control }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <button @click="onBtExport"
                            class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <i class="fas fa-file-excel mr-2"></i> Descargar Indicadores
                    </button>
                </div>

                <ag-grid-vue
                    :rowData="estateIndicators"
                    :columnDefs="columnsTable"
                    style=""
                    class="ag-theme-quartz h-screen"
                    rowSelection="multiple"

                    @grid-ready="onGridReady"
                >
                </ag-grid-vue>

            </div>
            <div class="w-full mt-4"
                 v-if="$page.props.auth.user.role_id != 2 && Object.keys(estateIndicatorsAdviser).length > 0">
                <div class="grid grid-cols-1 gap-2">
                    <div class="bg-white mx-8 shadow overflow-x-auto sm:rounded-lg px-3">
                        <div class="container mx-1 ">
                            <div class="bg-white shadow-md rounded my-6">
                                <table class="table-auto">
                                    <thead>
                                    <tr>
                                        <th colspan="13">Control de Indicadores</th>
                                    </tr>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">Cod Regional</th>
                                        <th class="py-3 px-6 text-left">Cod Dependencia</th>
                                        <th class="py-3 px-6 text-left">Dependencia</th>
                                        <th class="py-3 px-6 text-left">Nombre de Indicador</th>

                                        <th class="py-3 px-6 text-left">Nombre de Perspectiva</th>

                                        <th class="py-3 px-6 text-left">Nombre de Objetivo Estrategico</th>

                                        <th class="py-3 px-6 text-left">Nombre de Indicador Estrategico</th>
                                        <th class="py-3 px-6 text-left">Mes</th>
                                        <th class="py-3 px-6 text-left">Meta</th>
                                        <th class="py-3 px-6 text-left">Objetivos de ejecución</th>
                                        <th class="py-3 px-6 text-left">Porcentaje ejecución</th>
                                        <th class="py-3 px-6 text-left">Estado</th>
                                        <!--<th class="py-3 px-6 text-left">Acción</th>-->
                                    </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                    <tr v-for="item in estateIndicatorsAdviser" :key="item.id"
                                        :class="{ 'bg-gray-100': item.status === 'Activo' }">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_estate.cod_reg
                                            }}
                                        </td>
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_estate.cod_dep
                                            }}
                                        </td>
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_estate.dependence
                                            }}
                                        </td>
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_indicator.name_indicator
                                            }}
                                        </td>

                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_indicator.name_perspective
                                            }}
                                        </td>

                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_indicator.name_strategy
                                            }}
                                        </td>

                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_indicator.name_indicator_strategy
                                            }}
                                        </td>
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.month }}</td>
                                        <td class="py-3 px-6 text-left">{{ item.goal }}</td>
                                        <td class="py-3 px-6 text-left">{{ item.execution_goals }}</td>
                                        <td class="py-3 px-6 text-left">{{
                                                parseFloat((item.execution_goals / item.goal) * 100).toFixed(2)
                                            }}%
                                        </td>
                                        <td class="py-3 px-6 text-left">{{ item.status }}</td>
                                        <!--<td class="py-3 px-1 center">
                                            <div class="grid grid-cols-1 gap-1">
                                                <div class="col-auto">
                                                    <button
                                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                                        v-if="item.cicly_indicator == 2 && $page.props.auth.user.role_id != 5"
                                                        @click="goJustify(item)">
                                                        Justifcación de Control
                                                    </button>
                                                </div>
                                            </div>
                                        </td>-->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Modal :show="showModalJustifyOne" maxWidth="w-full" :closeable="true">
                <JusitfyEstateValidity :viability="validity" :estates="estates" :followUp="selectFollow" :cicle="cicle"
                                       @close="closeJustifyOne"></JusitfyEstateValidity>
            </Modal>
        </div>

    </AppLayout>
</template>
