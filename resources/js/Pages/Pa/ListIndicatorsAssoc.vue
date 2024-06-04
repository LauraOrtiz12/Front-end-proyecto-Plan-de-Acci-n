<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import {ref} from 'vue';
import {AgGridVue} from "ag-grid-vue3";
import Modal from "@/Components/Modal.vue";
import Swal from "sweetalert2";

const props = defineProps({
    indicators: Object,
    estate: Object
});

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

const onGridReady = (params) => {
    gridApi.value = params.api;
};

const columnsTable = [
    {field: 'id', headerName: 'ID Indicador', filter: true, floatingFilter: true, checkboxSelection: true},
    {field: '.name_indicator', headerName: 'Nombre Indicador', filter: true, floatingFilter: true},
    {field: 'perspective', headerName: 'Perspectiva', filter: true, floatingFilter: true},
    {field: 'name_perspective', headerName: 'Nombre de Perspectiva', filter: true, floatingFilter: true},
    {field: 'objective_strategy', headerName: 'Objetivo Estrategico', filter: true, floatingFilter: true},
    {field: 'name_strategy', headerName: 'Nombre Estrategico', filter: true, floatingFilter: true},
    {field: 'indicator_strategy', headerName: 'Indicador Estrategico', filter: true, floatingFilter: true},
    {field: 'name_indicator_strategy', headerName: 'Nombre Indicador Estrategico', filter: true, floatingFilter: true},
    {field: 'status', headerName: 'Estado', filter: true, floatingFilter: true},
];

const columnsTableAssoc = [
    {field: 'id', headerName: 'ID Indicador', filter: true, floatingFilter: true, checkboxSelection: true},
    {field: 'get_indicator.name_indicator', headerName: 'Nombre Indicador', filter: true, floatingFilter: true},
    {field: 'get_indicator.perspective', headerName: 'Perspectiva', filter: true, floatingFilter: true},
    {field: 'get_indicator.name_perspective', headerName: 'Nombre de Perspectiva', filter: true, floatingFilter: true},
    {field: 'get_indicator.objective_strategy', headerName: 'Objetivo Estrategico', filter: true, floatingFilter: true},
    {field: 'get_indicator.name_strategy', headerName: 'Nombre Estrategico', filter: true, floatingFilter: true},
    {field: 'get_indicator.indicator_strategy', headerName: 'Indicador Estrategico', filter: true, floatingFilter: true},
    {field: 'get_indicator.name_indicator_strategy', headerName: 'Nombre Indicador Estrategico', filter: true, floatingFilter: true},
    {field: 'goal', headerName: 'Meta', filter: true, floatingFilter: true},
    {field: 'execution_goals', headerName: 'Ejecución de Meta', filter: true, floatingFilter: true},
    {field: 'created_at', headerName: 'Fecha', filter: true, floatingFilter: true},
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

        axios.get('/estateIndicatorsAdmin', {params: {validity: validity.value, estate_id: props.estate.cod_dep}})
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
    })
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
    <AppLayout>
        <template #header>
            Indicadores Asignados o por Asignar
        </template>
        <div class="container mx-auto py-10 sm:px-6 lg:px-8">
            <div class="info-box mx-3 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-3">
                    <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">
                        ID: {{ $page.props.estate.id }}
                    </div>
                    <p class="mt-2 text-gray-500">Código Región: {{ $page.props.estate.cod_reg }}</p>
                    <p class="mt-2 text-gray-500">Código Dependencia: {{ $page.props.estate.cod_dep }}</p>
                    <p class="mt-2 text-gray-500">Dependencia Control: {{ $page.props.estate.dependence_control }}</p>
                    <p class="mt-2 text-gray-500">Dependencia: {{ $page.props.estate.dependence }}</p>
                </div>
            </div>

            <div class="form-section grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
                <select v-model="validity" class="w-full p-2 border border-gray-300 rounded">
                    <option :value="i.id" v-for="i in $page.props.viability">{{ i.validity }}</option>
                </select>
                <button @click="getIndicators" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Validar
                </button>
            </div>

            <div class="result-section bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6" v-if="estateValidator">
                <button @click="openModalImport = !openModalImport"
                        class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                    Importar Excel
                </button>

                <div class="py-6 px-2 section-title">Asignados</div>
                <div class="ag-grid-section px-2 mb-6">
                    <ag-grid-vue
                        :rowData="selectIndicatorTableTwo"
                        :columnDefs="columnsTableAssoc"
                        class="ag-theme-quartz h-64"
                        rowSelection="multiple"
                        @selection-changed="onSelectionChanged"
                        @grid-ready="onGridReady">
                    </ag-grid-vue>
                </div>

                <div class="py-6 px-2 section-title">Por Asignar</div>
                <div class="ag-grid-section px-2">
                    <ag-grid-vue
                        :rowData="indicators"
                        :columnDefs="columnsTable"
                        class="ag-theme-quartz h-screen"
                        rowSelection="multiple"
                        @selection-changed="onSelectionChanged"
                        @grid-ready="onGridReady">
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
<style>
.section-title {
    font-size: 1.5rem; /* Tamaño de fuente */
    font-weight: bold; /* Peso de la fuente */
    color: #333; /* Color del texto */
    margin-bottom: 1rem; /* Margen inferior */
    border-bottom: 2px solid #e5e7eb; /* Línea inferior */
    padding-bottom: 0.5rem; /* Padding inferior */
}
</style>
