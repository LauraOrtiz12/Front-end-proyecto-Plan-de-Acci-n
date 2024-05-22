<script setup>

import {ref} from 'vue';
import "ag-grid-community/styles/ag-grid.css"; // Mandatory CSS required by the grid
import "ag-grid-community/styles/ag-theme-quartz.css"; // Optional Theme applied to the grid
import {AgGridVue} from "ag-grid-vue3";
import {useForm} from "@inertiajs/vue3";
import Swal from "sweetalert2";

const autoSizeStrategy = ref(null);

const props = defineProps({
    estates: Object,
    users: Object,
    edit: null
});

const columnsTable = [
    {field: 'cod_reg', headerName: 'Código de Regional', filter: true, floatingFilter: true, checkboxSelection: true},
    {field: 'cod_dep', headerName: 'Código de Dependencia', filter: true, floatingFilter: true},
    {field: 'dependence', headerName: 'Dependencia', filter: true, floatingFilter: true},
    {field: 'get_responsible.name', headerName: 'Responsable', filter: true, floatingFilter: true},
    {field: 'get_adviser.name', headerName: 'Responsable Control', filter: true, floatingFilter: true},
];

const viewForm = ref(false);

const form = useForm({
    id: 0,
    cod_reg: null,
    cod_dep: null,
    dependence: null,
    responsible_id: null,
    adviser_id: null,
});

const save = () => {

    Swal.fire({
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
            form.post('newEstates', {
                onSuccess: (res) => {
                    form.reset()
                    console.log(res)
                }
            });

        }
    });
}


</script>

<template>
    <div class="card">
        <ag-grid-vue
            :rowData="$page.props.estates"
            :columnDefs="columnsTable"
            style="height: 500px"
            :autoSizeStrategy="autoSizeStrategy"
            class="ag-theme-quartz"
            rowSelection="multiple"
            :suppressRowClickSelection="true"s
        >
        </ag-grid-vue>
    </div>

</template>
<style scoped>
</style>
