<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import { ref } from 'vue';
import { AgGridVue } from "ag-grid-vue3";
import Modal from "@/Components/Modal.vue";
import Swal from "sweetalert2";
import Tab from "@/Components/Tab.vue";

const props = defineProps({
    indicators: Object,
    estate: Object
});

const pageTitle = "Indicadores Asignados o por Asignar";
const selectorIndicator = ref([]);
const gridApi = ref();
const validity = ref(0);
const estateIndicators = ref([]);
const estateValidator = ref(false);
const openModalImport = ref(false);
const fileImport = ref(null);
const indicators = ref([]);
const selectIndicatorTable = ref([]);
const selectIndicatorTableTwo = ref([]);
const selectIndicatorMoney = ref();

const onGridReady = (params) => {
    gridApi.value = params.api;
};

const columnsTable = [
    { field: 'id', headerName: 'ID Indicador', filter: true, floatingFilter: true, checkboxSelection: true },
    { field: '.name_indicator', headerName: 'Nombre Indicador', filter: true, floatingFilter: true },
    { field: 'perspective', headerName: 'Perspectiva', filter: true, floatingFilter: true },
    { field: 'name_perspective', headerName: 'Nombre de Perspectiva', filter: true, floatingFilter: true },
    { field: 'objective_strategy', headerName: 'Objetivo Estrategico', filter: true, floatingFilter: true },
    { field: 'name_strategy', headerName: 'Nombre Estrategico', filter: true, floatingFilter: true },
    { field: 'indicator_strategy', headerName: 'Indicador Estrategico', filter: true, floatingFilter: true },
    { field: 'name_indicator_strategy', headerName: 'Nombre Indicador Estrategico', filter: true, floatingFilter: true },
    { field: 'status', headerName: 'Estado', filter: true, floatingFilter: true },
];
const columnsTableAssoc = [
    { field: 'id', headerName: 'ID Indicador', filter: true, floatingFilter: true, checkboxSelection: true },
    { field: 'get_indicator.name_indicator', headerName: 'Nombre Indicador', filter: true, floatingFilter: true },
    { field: 'get_indicator.perspective', headerName: 'Perspectiva', filter: true, floatingFilter: true },
    { field: 'get_indicator.name_perspective', headerName: 'Nombre de Perspectiva', filter: true, floatingFilter: true },
    { field: 'get_indicator.objective_strategy', headerName: 'Objetivo Estrategico', filter: true, floatingFilter: true },
    { field: 'get_indicator.name_strategy', headerName: 'Nombre Estrategico', filter: true, floatingFilter: true },
    { field: 'get_indicator.indicator_strategy', headerName: 'Indicador Estrategico', filter: true, floatingFilter: true },
    { field: 'get_indicator.name_indicator_strategy', headerName: 'Nombre Indicador Estrategico', filter: true, floatingFilter: true },
    { field: 'goal', headerName: 'Meta', filter: true, floatingFilter: true },
    { field: 'execution_goals', headerName: 'Ejecución de Meta', filter: true, floatingFilter: true },
    {
        field: 'compliance',
        headerName: '% Cumplimiento',
        filter: true,
        floatingFilter: true,
        cellRenderer: (params) => {
            const executionGoals = params.data.execution_goals;
            const goal = params.data.goal;
            const compliance = (goal > 0) ? (executionGoals / goal) * 100 : 0;
            return compliance.toFixed(2) + '%';
        }
    },
    { field: 'created_at', headerName: 'Fecha', filter: true, floatingFilter: true },
];

const columnsTableAssocMoney = [
    { field: 'id', headerName: 'ID Indicador', filter: true, floatingFilter: true, checkboxSelection: true },
    { field: 'siif', headerName: 'DEP SIIF', filter: true, floatingFilter: true },
    { field: 'project_id', headerName: 'Codigo Proyecto', filter: true, floatingFilter: true },
    { field: 'get_project.project', headerName: 'Proyecto', filter: true, floatingFilter: true },
    { field: 'open_money', headerName: 'Apertura', filter: true, floatingFilter: true },
    { field: 'commitment', headerName: 'Apertura', filter: true, floatingFilter: true },
    { field: 'payments', headerName: 'Pagos', filter: true, floatingFilter: true },
    { field: 'commitment_percentage', headerName: 'Porcentaje Comprometido', filter: true, floatingFilter: true },
    { field: 'payment_execution', headerName: 'Pago Ejecutado', filter: true, floatingFilter: true },
    { field: 'created_at', headerName: 'Fecha', filter: true, floatingFilter: true },
];

const onSelectionChanged = (data) => {
    let selected = gridApi.value.getSelectedRows();
    selectorIndicator.value = [];
    selected.forEach(function (selectedRow, index) {
        selectorIndicator.value.push(selectedRow.id);
    });
}

const getIndicators = () => {
    const exist = [];
    const other = [];
    axios.get('/getIndicators').then(response => {
        const allIndicator = response.data;

        axios.get('/estateIndicatorsAdmin', { params: { validity: validity.value, estate_id: props.estate.cod_dep } })
            .then((response) => {
                const select = [];
                for (let assigngIndicator in response.data) {
                    select.push(response.data[assigngIndicator].indicator_id);
                }
                selectIndicatorTableTwo.value = response.data;
                for (let x in allIndicator) {
                    if (select.includes(allIndicator[x].id)) {
                        selectIndicatorTable.value.push(allIndicator[x]);
                    } else {
                        indicators.value.push(allIndicator[x]);
                    }
                }
                estateValidator.value = true;
            });
    });

    axios.get('/getIndicatorsMoney', { params: { validity: validity.value, estate_id: props.estate.cod_dep } }).then(response => {
        selectIndicatorMoney.value = response.data;
    });
}

const save = () => {

}

const loadFile = (event) => {
    fileImport.value = event.target.files[0];
}
const importFile = () => {
    const formData = new FormData();
    formData.append('estate_id', props.estate.cod_dep);
    formData.append('validity_id', validity.value);
    formData.append('file', fileImport.value);
    axios.post('importExcelIndicator', formData).then((response) => {
        console.log(response);
        openModalImport.value = !openModalImport.value;
        if (response.status == 200) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Error al Cargar el Archivo",
            });
        }
        if (response.status == 201) {
            Swal.fire({
                icon: "success",
                title: "Excelente",
                text: "Archivo Cargado",
            });
        }
    })

}

</script>

<template>
    <AppLayout :title="pageTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-secondary-default my-auto">{{ pageTitle }}</h2>
        </template>
        <div class="flex flex-col gap-4">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex flex-col">
                    <p class="text-lg font-semibold">ID: {{ $page.props.estate.id }}</p>
                    <p class="text-sm text-gray-500">Código Región: {{ $page.props.estate.cod_reg }}</p>
                    <p class="text-sm text-gray-500">Código Dependencia: {{ $page.props.estate.cod_dep }}</p>
                    <p class="text-sm text-gray-500">Dependencia Control: {{ $page.props.estate.dependence_control }}
                    </p>
                    <p class="text-sm text-gray-500">Dependencia: {{ $page.props.estate.dependence }}</p>
                </div>
            </div>

            <div class="form-section flex flex-col gap-4 mt-6">
                <div class="flex items-center gap-4">
                    <select v-model="validity" class="w-full p-2 border border-gray-300 rounded-md">
                        <option :value="i.id" v-for="i in $page.props.viability">{{ i.validity }}</option>
                    </select>
                    <button @click="getIndicators"
                        class="transition-all px-6 py-2 text-secondary-default bg-gray-200 rounded-md hover:bg-primary-default hover:text-white hover:scale-105">
                        Validar
                    </button>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg flex flex-col gap-4 pb-4" v-if="estateValidator">
                <button @click="openModalImport = !openModalImport"
                    class="transition-all w-full px-6 py-2 text-secondary-default bg-gray-200 rounded-t-md hover:bg-primary-default hover:text-white hover:scale-105">
                    Importar Excel
                </button>
                <h1 class="text-lg font-semibold px-4">Asignados</h1>
                <div class="px-4">
                    <Tab>
                        <template #t1>
                            <div class="ag-grid-section px-2 mb-6">
                                <ag-grid-vue :rowData="selectIndicatorTableTwo" :columnDefs="columnsTableAssoc"
                                    class="ag-theme-quartz h-64" rowSelection="multiple"
                                    @selection-changed="onSelectionChanged" @grid-ready="onGridReady">
                                </ag-grid-vue>
                            </div>
                        </template>
                        <template #t2>
                            <div class="ag-grid-section px-2 mb-6">
                                <ag-grid-vue :rowData="selectIndicatorMoney" :columnDefs="columnsTableAssocMoney"
                                    class="ag-theme-quartz h-64" rowSelection="multiple"
                                    @selection-changed="onSelectionChanged" @grid-ready="onGridReady">
                                </ag-grid-vue>
                            </div>
                        </template>
                    </Tab>
                </div>
                <h1 class="text-lg font-semibold px-4">Por Asignar</h1>
                <div class="ag-grid-section px-4">
                    <ag-grid-vue :rowData="indicators" :columnDefs="columnsTable" class="ag-theme-quartz h-screen"
                        rowSelection="multiple" @selection-changed="onSelectionChanged" @grid-ready="onGridReady">
                    </ag-grid-vue>
                </div>
            </div>
        </div>

        <Modal :show="openModalImport" class="py-8" :closeable="true">
            <div class="modal-container max-w-md mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg">
                <div class="modal-header mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Carga Masiva de Indicadores a Dependencia</h1>
                </div>
                <div class="modal-body mb-6">
                    <input type="file" @change="loadFile"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors duration-300"
                        accept="">
                </div>
                <div class="modal-footer flex justify-end mb-6">
                    <button v-if="fileImport" @click="importFile"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-300">
                        Cargar
                    </button>
                </div>
                <div class="modal-actions flex justify-between items-center">
                    <a href="/format/Assoc_Indicator.xlsx"
                        class="text-blue-600 hover:underline hover:text-blue-800 transition-colors duration-300">
                        Descargar Plantilla XLSX
                    </a>
                    <button @click="openModalImport = !openModalImport"
                        class="text-red-600 hover:underline hover:text-red-800 transition-colors duration-300">
                        Cerrar
                    </button>
                </div>
            </div>

        </Modal>
    </AppLayout>
</template>

