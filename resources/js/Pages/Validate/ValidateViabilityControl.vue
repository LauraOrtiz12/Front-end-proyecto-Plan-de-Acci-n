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
import Card from "@/Components/card.vue";
import Buttons from "@/Components/buttons.vue";
import Tab from "@/Components/Tab.vue";


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
const estateIndicatorsAdviserMoney = ref([]);
const followUp = ref({});
const showModalJustifyOne = ref(false);
const cicle = ref(1);
const followUps = ref();
const justifyControl = ref('');
const gridApi = ref();
const gridApiMoney = ref();


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
            return `${(parseFloat(params.data.execution_goals) / parseFloat(params.data.goal) * 100).toFixed(2)}%`;
        }, cellStyle: params => {
            let per = (parseFloat(params.data.execution_goals) / parseFloat(params.data.goal) * 100);
            let expGoal = parseFloat(params.data.expected_goal) * 100;
            if(expGoal === '0'){
                return {color: 'black', 'background-color': 'white'};
            }
            if(per >= expGoal ){
                return { background: '#00B050' };
            }else{
                return { background: "#FE5935" };

            }
        }
    },
    {
        field: 'expected_goal', headerName: 'Porcentaje Esperado', filter: true, floatingFilter: true, cellRenderer: (params) => {
            return `${(parseFloat(params.data.expected_goal) * 100).toFixed(2)}%`;
        },
    },
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
            return `${(parseFloat(params.data.commitment_percentage)*100).toFixed(2)}%`;
        }, tooltipValueGetter: (p) => "El porcentaje esperado es de 45.17%", headerTooltip: "io",
        cellStyle: params => {
            let exp = 45.17;
            let val = parseFloat(params.data.commitment_percentage)*100;
            if(exp < val){
                return { background: '#00B050' };
            }else{
                return { background: "#FE5935" };

            }
        }
    },
    {
        field: 'payment_execution',
        headerName: 'Porcentaje Pago',
        filter: true,
        floatingFilter: true,
        cellRenderer: (params) => {
            return `${parseFloat(params.data.payment_execution*100).toFixed(2)}%`;
        }, tooltipValueGetter: (p) => "El porcentaje esperado es de 10.84%",
        cellStyle: params => {
            let exp = 10.84;
            let val = parseFloat(params.data.payment_execution)*100;
            if(exp < val){
                return { background: '#00B050' };
            }else{
                return { background: "#FE5935" };
            }
        }
    },
];

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

const loadViabilityControl = () => {
    const adviser = props.user.get_estate_indicator_adviser.map(res => res.id);
    axios.get('getDataAdviser', {params: {validity: validity.value, adviser: adviser}})
        .then((response) => {
            estateIndicatorsAdviser.value = response.data.indicator;
            followUps.value = response.data.followups;
            estateIndicatorsAdviserMoney.value = response.data.indicatorMoney;
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
const onGridReadyMoney = (params) => {
    gridApiMoney.value = params.api;
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
                <select class="rounded-md" name="viability" id="viability" v-model="validity">
                    <option value="" disabled selected>Seleccione el año</option>
                    <option :value="via.id" v-for="via in viability" :key="via.id">{{ via.validity }}</option>
                </select>
                <Buttons @click="loadViabilityControl"
                         v-if="(Object.keys($page.props.estatesControl).length > 0 || Object.keys($page.props.estates).length > 0) && validity > 0">
                    Validar
                </Buttons>
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
            <div class="rounded-md overflow-x-auto shadow-md">
                <table class="table-auto w-full bg-white min-w-[1248px]">
                    <thead class="bg-secondary-default text-white">
                    <tr>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-hashtag"></i> Cod
                            Dependencia
                        </th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-file-lines"></i>
                            Justificación
                            de Indicadores
                        </th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-file-invoice-dollar"></i>
                            Justificación Presupuestal
                        </th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-regular fa-calendar-days"></i>
                            Fecha
                        </th>
                        <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-comment-dots"></i>
                            Observación
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y-4 divide-white">
                    <tr v-for="item in followUps" :key="item.id"
                        :class="[{ 'bg-gray-100': item.status === 'Activo' }, 'divide-x-4 divide-white']">
                        <td class="bg-gray-200 px-4 py-3">
                            <div class="grid grid-cols-1">
                                {{ item.estate_id }}
                                <a :href="`export/followup/dep?id=${item.id}&relation=${item.status === 'Activo' ? 0 : 1 }`" class="bg-green-600 text-white w-12 h-12 flex items-center justify-center rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                                    <i class="fas fa-file-excel"></i>
                                </a>
                                <span v-if="item.get_follow_close.status != 'Activo'"
                                      class="bg-red-100 text-red-700 px-4 py-2 rounded font-thin text-xs">
                                        Seguimento Cerrado
                                </span>
                            </div>

                        </td>
                        <td class="bg-gray-100 px-4 py-3">{{
                                item.justify_estate_indicator
                            }}
                        </td>
                        <td class="bg-gray-200 px-4 py-3">{{ item.justify_estate_money }}
                        </td>
                        <td class="bg-gray-100 px-4 py-3 text-sm">{{ formatDate(item.created_at) }}
                        </td>
                        <td class="bg-gray-200 px-4 py-3" v-if="item.cicle == 2">
                            <div class="grid grid-cols-1 gap-3" v-if="item.status == 'Activo'">
                                    <textarea :name="`updateJustify` + item.id" :id="`updateJustify` + item.id"
                                              cols="30" rows="5" class="w-full px-3 py-2 border rounded-md">{{ item.observation_control == null
                                            ?
                                '' : item.observation_control}}</textarea>
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
                        <td class="bg-gray-200 px-4 py-3" v-else>
                            {{ item.observation_control }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <Card class="w-full">
                <div class="w-ful flex flex-col gap-4 p-3"
                     v-if="$page.props.auth.user.role_id != 2 && Object.keys(estateIndicatorsAdviser).length > 0">
                    <div class="flex justify-between items-center flex-wrap">
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <Tab>
                            <template #t1>
                                <ag-grid-vue :rowData="estateIndicatorsAdviser" :columnDefs="columnsTable" style=""
                                             class="ag-theme-quartz h-screen" rowSelection="multiple"
                                             @grid-ready="onGridReady" :columnHoverHighlight="true">
                                </ag-grid-vue>
                            </template>
                            <template #t2>
                                <ag-grid-vue :rowData="estateIndicatorsAdviserMoney"
                                             :columnDefs="columnsTableAssocMoney" style=""
                                             class="ag-theme-quartz h-screen" rowSelection="multiple"
                                             @grid-ready="onGridReadyMoney" :columnHoverHighlight="true">
                                </ag-grid-vue>
                            </template>
                        </Tab>

                    </div>
                </div>
            </Card>
            <Modal :show="showModalJustifyOne" maxWidth="w-full" :closeable="true">
                <JusitfyEstateValidity :viability="validity" :estates="estates" :followUp="followUp" :cicle="cicle"
                                       @close="closeJustifyOne"></JusitfyEstateValidity>
            </Modal>
        </div>
    </AppLayout>
</template>
