<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import { AgGridVue } from "ag-grid-vue3";
import ButtonAction from "@/Components/ButtonAction.vue";
import Tab from "@/Components/Tab.vue";

const pageTitle = "Listar Indicadores";

const props = defineProps({
    indicators: Object,
    indicatorMoney: Object
});

const columnsTable = [
    { field: 'indicator', headerName: 'Indicador', filter: true, floatingFilter: true, suppressSizeToFit: true, width: 120 },
    { field: 'name_indicator', headerName: 'Nombre Indicador', filter: true, floatingFilter: true },
    { field: 'name_perspective', headerName: 'Nombre de Perspectiva', filter: true, floatingFilter: true },
    { field: 'objective_strategy', headerName: 'Objetivo Estrategico', filter: true, floatingFilter: true },
    { field: 'indicator_strategy', headerName: 'Indicador Estrategico', filter: true, floatingFilter: true },
    { field: 'area', headerName: 'Área Responsable', filter: true, floatingFilter: true },
];

const columnsTableMoney = [
    { field: 'siif', headerName: 'SIIF', filter: true, floatingFilter: true, suppressSizeToFit: true, width: 50 },
    { field: 'project_id', headerName: 'Código Proyecto', filter: true, floatingFilter: true },
    { field: 'project', headerName: 'Proyecto', filter: true, floatingFilter: true, suppressSizeToFit: true, width: 900 },
];
</script>
<template>
    <AppLayout :title="pageTitle">
        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">{{pageTitle}}</h1>
        </template>
        <div class="flex w-full flex-1">
            <Tab class="flex-1">
                <template #t1>
                    <ag-grid-vue :rowData="$page.props.indicators" :columnDefs="columnsTable" 
                                 class="ag-theme-quartz h-full" >
                    </ag-grid-vue>
                </template>
                <template #t2>
                    <ag-grid-vue :rowData="$page.props.indicatorMoney" :columnDefs="columnsTableMoney"
                                 class="ag-theme-quartz h-full" >
                    </ag-grid-vue>
                </template>
            </Tab>
        </div>
    </AppLayout>
</template>
