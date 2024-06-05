<script setup>

import {ref, onMounted, defineProps} from 'vue';
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import {AgGridVue} from "ag-grid-vue3";
import Swal from "sweetalert2";

const gridApi = ref();
const selectorIndicator = ref([]);
const dataEstates = ref({});

const props = defineProps({
    estates: Object,
    user: Object,
    edit: null
});

const emit = defineEmits(['close'])
onMounted(() => {
    dataEstates.value = props.estates;
    let advisorIds = props.user.get_adviser_office.map(advisor => advisor.estate_id);
    for (const key in props.estates) {
    }
});

const columnsTable = [
    {field: 'cod_reg', headerName: 'Código de Regional', filter: true, floatingFilter: true, checkboxSelection: true},
    {field: 'cod_dep', headerName: 'Código de Dependencia', filter: true, floatingFilter: true},
    {field: 'dependence', headerName: 'Dependencia', filter: true, floatingFilter: true},
    //{field: 'get_responsible.name', headerName: 'Responsable', filter: true, floatingFilter: true},
    //{field: 'get_adviser.name', headerName: 'Responsable Control', filter: true, floatingFilter: true},
];

const onGridReady = (params) => {
    gridApi.value = params.api;
};

const onSelectionChanged = (data) => {
    let selected = gridApi.value.getSelectedRows();
    selectorIndicator.value = [];
    selected.forEach(function (selectedRow, index) {
        selectorIndicator.value.push(selectedRow.id);
    });
    form.value.estate_id = selectorIndicator.value
}

const form = ref({
    advisor_id: props.user.id,
    estate_id: null,
});

const save = () => {

    Swal.fire({
        target: "#card-assoc",
        title: "Aviso Importante?",
        text: "Está usted Seguro!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post('advisorOffices', form.value)
                .then(response => {
                    emit('close');
                });
        }
    });
}
</script>
<template>
    <div class="grid grid-cols-1" v-if="dataEstates.length > 0" id="card-assoc">
        <div class="bg-gray-100">Dependencias</div>
            <ag-grid-vue
                :rowData="dataEstates"
                :columnDefs="columnsTable"
                style="height: 80vh; width: 100vw"
                class="ag-theme-quartz"
                rowSelection="multiple"
                @selection-changed="onSelectionChanged"
                @grid-ready="onGridReady"
            >
            </ag-grid-vue>
        <div class="p-3">
            <button v-if="selectorIndicator.length > 0 " @click="save"
                    class="inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fa-solid fa-save mr-1"></i>
                Guardar
            </button>
        </div>
    </div>
</template>

