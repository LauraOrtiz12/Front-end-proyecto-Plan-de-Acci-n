<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import {ref, onMounted} from 'vue';
import ButtonAction from "@/Components/ButtonAction.vue";
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
    {field: 'cod_reg', headerName: 'Código de Regional', filter: true, floatingFilter: true},
    {field: 'cod_dep', headerName: 'Código de Dependencia', filter: true, floatingFilter: true},
    {field: 'dependence', headerName: 'Dependencia', filter: true, floatingFilter: true},
    {field: 'get_responsible.name', headerName: 'Responsable', filter: true, floatingFilter: true},
    {field: 'get_adviser.name', headerName: 'Responsable Control', filter: true, floatingFilter: true},
    {field: 'id', headerName: 'Acciones', cellRenderer: ButtonAction},
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

if (props.edit > 0) {
    viewForm.value = true;
    props.estates.filter((est) => {
        if (est.id == props.edit) {
            form.id = est.id;
            form.cod_reg = est.cod_reg;
            form.cod_dep = est.cod_dep;
            form.dependence = est.dependence;
            form.responsible_id = est.responsible_id;
            form.adviser_id = est.adviser_id;
        }
    });
    //form.cod_reg = 1000;
}

</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-secondary-default my-auto">
                Listar Dependencias
            </h2>
        </template>
        <div class="flex flex-col gap-4">
            <div class="flex justify-end">
                <button class="bg-primary-default hover:bg-secondary-default text-white font-bold py-2 px-4 rounded transition ease-in-out duration-150"
                        @click="viewForm = !viewForm">Nueva Dependencia
                </button>
            </div>
            <div v-if="viewForm">
                <div class="w-100 bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">Crear Elemento</h2>
                    <form id="myForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-2">
                        <div class="flex flex-col">
                            <label for="cod_reg" class="text-sm font-semibold mb-1">Cód.Regional</label>
                            <input type="text" id="cod_reg" name="cod_reg"
                                   class="rounded py-2 px-3 focus:outline-none focus:border-blue-500"
                                   v-model="form.cod_reg">
                        </div>
                        <div class="flex flex-col md:col-span-2">
                            <label for="cod_dep" class="text-sm font-semibold mb-1">Cód. Dependencia</label>
                            <input type="text" id="cod_dep" name="cod_dep"
                                   class="border rounded py-2 px-3 focus:outline-none focus:border-blue-500"
                                   v-model="form.cod_dep">
                        </div>
                        <div class="flex flex-col md:col-span-4">
                            <label for="dependence" class="text-sm font-semibold mb-1">Dependencia</label>
                            <input type="text" id="dependence" name="dependence"
                                   class="border rounded py-2 px-3 focus:outline-none focus:border-blue-500"
                                   v-model="form.dependence">
                        </div>
                        <div class="flex flex-col md:col-span-3">
                            <label for="responsible_id" class="text-sm font-semibold mb-1">ID del Responsable</label>
                            <select name="" id="" v-model="form.responsible_id">
                                <option value="">Seleccionar</option>
                                <option :value="user.id" :key="user.id" v-for="user in $page.props.users">
                                    {{ user.name + ' / ' + user.email }}
                                </option>
                            </select>
                        </div>
                        <div class="flex flex-col md:col-span-2">
                            <label for="adviser_id" class="text-sm font-semibold mb-1">ID del Asesor</label>
                            <select name="" id="" v-model="form.adviser_id">
                                <option value="">Seleccionar</option>
                                <option :value="user.id" :key="user.id" v-for="user in $page.props.users">
                                    {{ user.name + ' / ' + user.email }}
                                </option>
                            </select>
                        </div>
                        <button type="button" @click="save"
                                class="col-span-full bg-primary-default hover:bg-secondary-default text-white font-bold py-2 px-4 rounded transition ease-in-out duration-150">
                            Crear / Actualizar
                        </button>
                    </form>
                </div>
            </div>
            <div class="card">
                <ag-grid-vue
                    :rowData="$page.props.estates"
                    :columnDefs="columnsTable"
                    style="height: 500px"
                    :autoSizeStrategy="autoSizeStrategy"
                    class="ag-theme-quartz"
                >
                </ag-grid-vue>
            </div>
        </div>
    </AppLayout>
</template>
<style scoped>
</style>
