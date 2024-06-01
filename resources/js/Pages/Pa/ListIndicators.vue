<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import { AgGridVue } from "ag-grid-vue3";
import ButtonAction from "@/Components/ButtonAction.vue";

const props = defineProps({
    indicators: Object,
});

const columnsTable = [
    { field: 'indicator', headerName: 'Indicador', filter: true, floatingFilter: true },
    { field: 'name_indicator', headerName: 'Nombre Indicador', filter: true, floatingFilter: true },
    { field: 'perspective', headerName: 'Perspectiva', filter: true, floatingFilter: true },
    { field: 'name_perspective', headerName: 'Nombre de Perspectiva', filter: true, floatingFilter: true },
    { field: 'objective_strategy', headerName: 'Objetivo Estrategico', filter: true, floatingFilter: true },
    { field: 'name_strategy', headerName: 'Nombre Estrategico', filter: true, floatingFilter: true },
    { field: 'indicator_strategy', headerName: 'Indicador Estrategico', filter: true, floatingFilter: true },
    { field: 'name_indicator_strategy', headerName: 'Nombre Indicador Estrategico', filter: true, floatingFilter: true },
    { field: 'status', headerName: 'Estado', filter: true, floatingFilter: true },
];

</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">Listar Indicadores</h1>
        </template>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="py-6 px-2">
                <ag-grid-vue :rowData="$page.props.indicators" :columnDefs="columnsTable" style=""
                    class="ag-theme-quartz h-screen">
                </ag-grid-vue>
            </div>
        </div>
    </AppLayout>
</template>
