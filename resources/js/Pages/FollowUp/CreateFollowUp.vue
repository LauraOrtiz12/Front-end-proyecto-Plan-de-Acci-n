<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from 'vue';
import Swal from "sweetalert2";
import Buttons from "@/Components/buttons.vue";
const pageTitle = "Generar Seguimiento";
const validity = ref(null);
const data = ref(null);
const selectMonth = ref('');
const activeFollow = ref(false);
const props = defineProps({
    validity: Object
});
const consult = () => {
    axios.get('consultFollowUp', {
        params: {
            validity_id: validity.value
        }
    }).then(response => {
        data.value = response.data;
    })
}
const saveFollow = () => {

    axios.post('createFollowUp', { validity_id: validity.value, month: selectMonth.value })
        .then(response => {
            if (response.status === 201) {
                Swal.fire({
                    title: "Seguimiento!",
                    text: "Se ha Generado Correctamente.",
                    icon: "success"
                });
                consult();
            } else {
                Swal.fire({
                    title: "Seguimiento!",
                    text: "No Se ha Generado Correctamente.",
                    icon: "error"
                });
            }
        });
}
const downloadRoute = () => {
    //exportDownload validity.value
    const url = `/exportDownload?validity=${validity.value}`;
    try {
        // Abre una nueva ventana o pestaña
        window.open(url, '_blank');
    } catch (error) {
        this.error = error.response ? error.response.data : error.message;
        console.error('Error fetching data:', error);
    }

}
//closeFollowUp
const closeFollowUp = (closeFollowUp) => {
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
            axios.post('closeFollowUp',
                {
                    validity_id: validity.value,
                    month: closeFollowUp[0].month
                }
            ).then(response => {
                console.log(response)
                if (response.status === 422) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Error",
                    });
                }
                if (response.status == 201) {
                    Swal.fire({
                        icon: "success",
                        title: "Excelente",
                        text: "Se ha cerrado correctamente el seguimiento",
                    });
                }
                consult();
            });
        }
    })
}

const downloadFollowClose = (month) => {
    //exportDownload validity.value
    const url = `/exportDownloadFollowClose?validity=${validity.value}&month=${month}`;
    try {
        // Abre una nueva ventana o pestaña
        window.open(url, '_blank');
    } catch (error) {
        this.error = error.response ? error.response.data : error.message;
        console.error('Error fetching data:', error);
    }

}

const downloadFollowCloseMoney = (month) => {
    //exportDownload validity.value
    const url = `/exportDownloadFollowCloseMoney?validity=${validity.value}&month=${month}`;
    try {
        // Abre una nueva ventana o pestaña
        window.open(url, '_blank');
    } catch (error) {
        this.error = error.response ? error.response.data : error.message;
        console.error('Error fetching data:', error);
    }

}
</script>
<template>
    <AppLayout :title="pageTitle">
        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">{{ pageTitle }}</h1>
        </template>

        <div class="flex flex-col gap-4">
            <div class="flex items-center py-2 gap-4">
                <span class="flex items-center px-3 py-1 rounded-lg text-secondary-default"><i
                        class="fa-solid fa-calendar-days mr-1"></i> Vigencia</span>
                <select
                    class="block w-40 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    name="viability" id="viability" v-model="validity">
                    <option :value="via.id" v-for="via in props.validity" :key="via.id">{{ via.validity }}</option>
                </select>
                <Buttons @click="consult">
                    Validar
                </Buttons>
            </div>
        </div>

        <div v-if="data != null">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg my-3" v-if="data.followUpClose == 0">
                <div class="grid grid-cols-1 md:grid-cols-4 justify-center items-center">
                    <div class="p-4">
                        <label for="">Mes a Activar Seguimiento
                            <select name="" id="" v-model="selectMonth"
                                class="block w-40 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccionar Mes</option>
                                <option :value="m" v-for="m in data.months">{{ m }}</option>
                            </select>
                        </label>
                    </div>
                    <div>
                        <label class="inline-flex items-center" v-if="selectMonth.length > 0">
                            <input type="checkbox" class="custom-checkbox" v-model="activeFollow">
                            <span class="ml-2">Habilitar</span>
                        </label>
                        <p class="mt-4">{{ activeFollow ? 'Activo' : 'Inactivo' }}</p>
                    </div>
                    <div v-if="selectMonth.length > 0 && activeFollow">
                        <button @click="saveFollow"
                            class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Generar Seguimiento
                        </button>
                    </div>
                    <div>
                        <span>Activa el seguimiento para la vigencia seleccionada y para el mes seleccionado</span>
                    </div>
                </div>
            </div>
            <div v-for="(month, info) in data.follow" :key="info"
                class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-4 p-6">
                <div class="border-b pb-4 mb-4">
                    <h2 class="text-lg font-semibold">Mes: {{ info }}
                    </h2>
                    <div v-if="month[0].status == 'Activo'"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">Estado: Activo</span>
                    </div>
                    <div v-else class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">Estado: Cerrado</span>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="font-medium">Generadas:</span>
                        <span class="text-gray-700">{{
                            parseInt(month[0].count) + parseInt(month[1].count) + parseInt(month[2].count)
                            }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="font-medium">Respuesta x Dependencia:</span>
                        <span class="text-gray-700">{{ parseInt(month[1].count) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="font-medium">Respuesta x Seguimiento:</span>
                        <span class="text-gray-700">{{ parseInt(month[2].count) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="font-medium">Faltantes:</span>
                        <span class="text-gray-700">{{ parseInt(month[0].count) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2" v-if="month[0].status == 'Activo'">
                        <button @click="closeFollowUp(month)" id="closeButton"
                            class="flex items-center bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01m-6.938 4h13.856C18.37 21 20 19.371 20 17.257V6.743C20 4.63 18.37 3 16.258 3H7.743C5.63 3 4 4.63 4 6.743v10.514C4 19.371 5.63 21 7.743 21z">
                                </path>
                            </svg>
                            Cerrar Seguimiento
                        </button>
                    </div>
                    <div class="flex justify-between items-center py-2" v-if="month[0].status == 'Activo'">
                        <div v-if="Object.keys(data.follow).length > 0"
                            class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-4 p-6">
                            <button @click="downloadRoute"
                                class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-file-excel mr-2"></i> Descargar Seguimiento
                            </button>
                            <span class="px-5">Descargar seguimiento de la vigencia</span>
                        </div>
                    </div>
                    <div v-else class="grid grid-cols-1 md:grid-cols-3">
                        <button @click="downloadFollowClose(month[0].month)"
                            class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-file-excel mr-2"></i> Descargar Seguimiento - Gestión
                        </button>
                        <button @click="downloadFollowCloseMoney(month[0].month)"
                            class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-file-excel mr-2"></i> Descargar Seguimiento - Presupuesto
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style scoped>
.custom-checkbox {
    @apply appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2;
}

.custom-checkbox:checked::after {
    content: "";
    display: block;
    width: 0.375rem;
    height: 0.75rem;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    position: relative;
    left: 50%;
    top: 25%;
}
</style>
