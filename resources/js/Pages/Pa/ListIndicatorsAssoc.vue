<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import {ref} from 'vue';
import {AgGridVue} from "ag-grid-vue3";
import ButtonAction from "@/Components/ButtonAction.vue";

const props = defineProps({
    indicators: Object,
});

const selectorIndicator = ref([]);
const gridApi = ref();
const validity = ref(0);

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

</script>

<template>
    <AppLayout>
        <template #header>
            Lista de Usuarios
        </template>
        <div>
            <div class="w-100 mx-auto py-10 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <select name="" id="" v-model="validity">
                        <option value="{{i.id}}" v-for="i in $page.props.viability">{{i.validity}}</option>
                    </select>
                    <div>
                        <button v-if="validity != 0 && selectorIndicator.length > 0" class="col-span-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Asociar Nuevo</button>
                    </div>

                </div>




                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="py-6 px-2">
                        <ag-grid-vue
                            :rowData="$page.props.indicators"
                            :columnDefs="columnsTable"
                            style=""
                            class="ag-theme-quartz h-screen"
                            rowSelection="multiple"
                            :suppressRowClickSelection="true"
                            @selection-changed="onSelectionChanged"
                            @grid-ready="onGridReady"
                        >
                        </ag-grid-vue>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
