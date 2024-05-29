<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import {ref} from 'vue';
import {AgGridVue} from "ag-grid-vue3";
import Modal from "@/Components/Modal.vue";

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

const onGridReady = (params) => {
    gridApi.value = params.api;
};

const columnsTable = [
    {field: 'indicator', headerName: 'Indicador', filter: true, floatingFilter: true, checkboxSelection: true},
    {field: 'name_indicator', headerName: 'Nombre Indicador', filter: true, floatingFilter: true},
    {field: 'perspective', headerName: 'Perspectiva', filter: true, floatingFilter: true},
    {field: 'name_perspective', headerName: 'Nombre de Perspectiva', filter: true, floatingFilter: true},
    {field: 'objective_strategy', headerName: 'Objetivo Estrategico', filter: true, floatingFilter: true},
    {field: 'name_strategy', headerName: 'Nombre Estrategico', filter: true, floatingFilter: true},
    {field: 'indicator_strategy', headerName: 'Indicador Estrategico', filter: true, floatingFilter: true},
    {field: 'name_indicator_strategy', headerName: 'Nombre Indicador Estrategico', filter: true, floatingFilter: true},
    {field: 'status', headerName: 'Estado', filter: true, floatingFilter: true},
];

const onSelectionChanged = (data) => {
    let selected = gridApi.value.getSelectedRows();
    selectorIndicator.value = [];
    selected.forEach(function (selectedRow, index){
        selectorIndicator.value.push(selectedRow.id);
    });
}

const getIndicators = () => {
    estateIndicators.value = [];
    axios.get('/estateIndicators', { params: { validity: validity.value } })
        .then((response) => {
            estateIndicators.value = response.data;
            if(estateIndicators.value.length == 0){
                estateValidator.value = true;
            }
            for(let assigngIndicator in estateIndicators.value) {
                console.log(estateIndicators.value[assigngIndicator].indicator_id);
                selectorIndicator.value.push(estateIndicators.value[assigngIndicator].indicator_id);
            }
            /*gridApi.value.forEachNode((node) => {
                if (node.data && node.data.id !== 2012) {
                    nodesToSelect.push(node);
                }
            });*/
            //gridApi.value.setNodesSelected({ nodes: selectorIndicator.value, newValue: true });
        });
}

const save = () => {

}

const loadFile = (event) => {
    fileImport.value = event.target.files[0];
}
const importFile = () => {

}

</script>

<template>
    <AppLayout>
        <template #header>
            Indicadores Asignados o por Asignar
        </template>
        <div class="">
            <div class=" mx-3 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="md:flex">
                    <div class="p-3">
                        <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">ID: {{ $page.props.estate.id }}</div>
                        <p class="mt-2 text-gray-500">Código Región: {{ $page.props.estate.cod_reg }}</p>
                        <p class="mt-2 text-gray-500">Código Dependencia: {{ $page.props.estate.cod_dep }}</p>
                        <p class="mt-2 text-gray-500">Dependencia Control: {{ $page.props.estate.dependence_control }}</p>
                        <p class="mt-2 text-gray-500">Dependencia: {{ $page.props.estate.dependence }}</p>
                    </div>
                </div>
            </div>

            {{selectorIndicator}}
            <div class="w-100 mx-auto py-10 sm:px-6 lg:px-8" >
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <select name="" id="" v-model="validity">
                        <option :value="i.id" v-for="i in $page.props.viability">{{i.validity}}</option>
                    </select>
                    <div>
                        <button @click="getIndicators" class="col-span-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Validar</button>
                    </div>


                    <div>
                        <button v-if="validity != 0 && selectorIndicator.length > 0" class="col-span-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Asociar Nuevo</button>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" v-if="estateValidator">
                    <div>
                        <div>
                            <button @click="openModalImport = !openModalImport" class="col-span-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Importar Excel</button>
                        </div>
                    </div>
                    <div class="py-6 px-2">
                        <ag-grid-vue
                            :rowData="$page.props.indicators"
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
        </div>
        <Modal :show="openModalImport" class="py-8">
            <div class="max-w-md mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg">
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Carga Masiva de Indicadores a Dependencia</h1>
                </div>
                <div class="mb-6">
                    <input type="file" name="" id="" @change="loadFile" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="">
                </div>
                <div class="flex justify-end">

                    <button v-if="fileImport"  @click="importFile" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-300">Cargar</button>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>
