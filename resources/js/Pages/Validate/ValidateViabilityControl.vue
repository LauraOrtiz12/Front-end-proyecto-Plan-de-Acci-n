<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from 'vue';
import {router} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import JusitfyEstateValidity from "@/Pages/Validate/JusitfyEstateValidity.vue";
import Swal from "sweetalert2";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import {AgGridVue} from "ag-grid-vue3";


const pageTitle = "Vigencia (Seguimiento)";

const props = defineProps({
    followUp: Object,
    viability: Object,
    estates: Object,
    estatesControl: Object,
    user: Object
});

const validity = ref('');
const estateIndicators = ref([]);
const estateIndicatorsAdviser = ref([]);
const followUp = ref({});
const showModalJustifyOne = ref(false);
const cicle = ref(1);
const followUps = ref();
const justifyControl = ref('');
const gridApi = ref();


const columnsTable = [
    {field: 'get_estate.cod_reg', headerName: 'Cod. Regional', filter: true, floatingFilter: true},
    {field: 'get_estate.cod_dep', headerName: 'Cod. Dependencia', filter: true, floatingFilter: true},
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

const loadViabilityControl = () => {
    const adviser = props.user.get_estate_indicator_adviser.map(res => res.id);
    axios.get('getDataAdviser', {params: {validity: validity.value, adviser: adviser}})
        .then((response) => {
            estateIndicatorsAdviser.value = response.data.indicator;
            followUps.value = response.data.followups;
        });
}

const goJustify = (item) => {
    router.get('justify/indicator', item)
}

const openJustifyOne = () => {
    showModalJustifyOne.value = !showModalJustifyOne.value;
}
const closeJustifyOne = () => {
    loadViabilityControl();
    showModalJustifyOne.value = !showModalJustifyOne.value;
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
            axios.post('updateFollowUp', {id: item.id, observation_control: text})
                .then((response) => {
                    loadViabilityControl();
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
};

const onGridReady = (params) => {
    gridApi.value = params.api;
}
const onBtExport = () => {
    gridApi.value.exportDataAsCsv({columnSeparator: "&"});
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
            axios.post('updateFollowUpState', {id: item.id, cicle: 1})
                .then((response) => {
                    loadViabilityControl();
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
                <select class="rounded-md" name="viability" id="viability"
                        v-model="validity">
                    <option value="" disabled selected>Seleccione el año</option>
                    <option :value="via.id" v-for="via in viability" :key="via.id">{{ via.validity }}</option>
                </select>
                <button @click="loadViabilityControl"
                        class="transition-all py-2 px-4 text-secondary-default bg-gray-200 rounded-md hover:text-white hover:bg-primary-default hover:scale-105"
                        v-if="Object.keys($page.props.estatesControl).length > 0 || Object.keys($page.props.estates).length > 0">
                    Validar
                </button>
            </div>
            <div class="flex flex-wrap lg:flex-nowrap gap-3 shadow p-3 rounded-md bg-white"
                 v-if="$page.props.auth.user.role_id == 3 || $page.props.auth.user.role_id == 4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Información de Usuario</h3>
                </div>
                <dl class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Nombre:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ $page.props.auth.user.name }}</dd>
                    </div>
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Correo Electrónico:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ $page.props.auth.user.email }}</dd>
                    </div>
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Rol:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ $page.props.user.get_role.rol }}</dd>
                    </div>
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Dependencia(s):</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2"
                            v-for="dependence in $page.props.user.get_estate_indicator_adviser"> {{ dependence.id }}-
                            {{ dependence.dependence }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="rounded-md overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="bg-secondary-default text-white   ">
                    <tr>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-hashtag"></i> Cod Dependencia
                        </th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-file-lines"></i> Justificación
                            de Indicadores
                        </th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-file-invoice-dollar"></i>
                            Justificación Presupuestal
                        </th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-regular fa-calendar-days"></i> Fecha
                        </th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-comment-dots"></i> Observación
                        </th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                    <tr v-for="item in followUps" :key="item.id" :class="{ 'bg-gray-100': item.status === 'Activo' }">
                        <td class="p-2 border border-gray-300 rounded-md bg-white">{{ item.estate_id }}</td>
                        <td class="p-2 border border-gray-300 rounded-md bg-white">{{ item.justify_estate_indicator }}
                        </td>
                        <td class="p-2 border border-gray-300 rounded-md bg-white">{{ item.justify_estate_money }}</td>
                        <td class="p-2 border border-gray-300 rounded-md bg-white">{{ formatDate(item.created_at) }}
                        </td>
                        <td class="py-3 px-6  text-left" v-if="item.cicle == 2">
                            <div class="grid grid-cols-1 gap-3" v-if="item.status == 'Activo'">
                                    <textarea :name="`updateJustify` + item.id" :id="`updateJustify` + item.id"
                                              cols="30"
                                              rows="5" class="w-full px-3 py-2 border rounded-md">{{item.observation_control == null ? '' : item.observation_control}}</textarea>
                                <button @click="update(item)"
                                        class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        v-if="Object.keys($page.props.estatesControl).length > 0 || Object.keys($page.props.estates).length > 0">
                                    Guardar
                                </button>
                                <button @click="rollBackSave(item)"
                                        class="ml-3 inline-flex items-center px-4 py-2 bg-secondary-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    No Validar
                                </button>
                            </div>
                            <span v-if="item.status != 'Activo'" class="bg-red-100 text-red-700 px-4 py-2 rounded">
                                      Seguimento Cerrado
                                </span>
                        </td>
                        <td class="p-2 border border-gray-300 rounded-md bg-white" v-else>
                            <div class="grid grid-cols-1">
                                {{ item.observation_control }}
                                <span v-if="item.status != 'Activo'" class="bg-red-100 text-red-700 px-4 py-2 rounded">
                                      Seguimento Cerrado
                                </span>
                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="w-full mt-4"
                 v-if="$page.props.auth.user.role_id != 2 && Object.keys(estateIndicatorsAdviser).length > 0">

                <div>
                    <button @click="onBtExport"
                            class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-file-excel mr-2"></i> Descargar Indicadores
                    </button>
                </div>
                Indicadores
                <div class="grid grid-cols-1 gap-2">
                    <ag-grid-vue :rowData="estateIndicatorsAdviser" :columnDefs="columnsTable" style=""
                                 class="ag-theme-quartz h-screen" rowSelection="multiple"
                                 @selection-changed="onSelectionChanged"
                                 @grid-ready="onGridReady">
                    </ag-grid-vue>
                </div>
            </div>
            <Modal :show="showModalJustifyOne" maxWidth="w-full" :closeable="true">
                <JusitfyEstateValidity :viability="validity" :estates="estates" :followUp="followUp" :cicle="cicle"
                                       @close="closeJustifyOne"></JusitfyEstateValidity>
            </Modal>
        </div>
    </AppLayout>
</template>
