<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from 'vue';
import {router} from "@inertiajs/vue3";

defineProps({
    viability: Object,
    estates: Object
});

const validity = ref('');
const estateIndicators = ref([]);
const loadViability = () => {
    axios.get('estateIndicators', { params: { validity: validity.value } })
        .then((response) =>  estateIndicators.value = response.data)
}

const goJustify = (item) => {
    router.get('justify/indicator', item)
}
</script>
<template>
    <AppLayout>
        <template #header>
            <div class="flex items-center">
                <span class="mr-2">Vigencia</span>
                <select class="block w-40 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="viability" id="viability" v-model="validity">
                    <option :value="via.id" v-for="via in viability" :key="via.id">{{via.validity}}</option>
                </select>
                <button @click="loadViability" class="ml-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" v-if="Object.keys($page.props.estates).length >0">
                    Validar
                </button>
            </div>
        </template>

        <div class="mt-4" v-if="$page.props.auth.user.role_id != 1 && Object.keys($page.props.estates).length > 0">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium text-gray-900">Información de la Propiedad</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles de la propiedad seleccionada</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl class="grid grid-cols-2 md:grid-cols-2 gap-4">
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Código de Regional:</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ estates.cod_reg }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Código de Dependencia:</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ estates.cod_dep }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Dependencia:</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ estates.dependence }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Responsable de Seguimiento:</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">{{ estates.get_adviser.name }} - Correo: {{ estates.get_adviser.email }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="text-center bg-white mt-1">
            <span>No Tiene Asociado una dependencia</span>
        </div>

        <div class="w-full mt-4" v-if="$page.props.auth.user.role_id != 1 && Object.keys($page.props.estates).length > 0">
            <div class="grid grid-cols-1 gap-2">
                <div class="bg-white mx-8 shadow overflow-x-auto sm:rounded-lg px-3">
                    <div class="container mx-1 ">
                        <div class="bg-white shadow-md rounded my-6">
                            <table class="table-auto">
                                <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nombre de Indicador</th>
                                    <th class="py-3 px-6 text-left">Perspectiva</th>
                                    <th class="py-3 px-6 text-left">Nombre de Perspectiva</th>
                                    <th class="py-3 px-6 text-left">Objetivo Estrategico</th>
                                    <th class="py-3 px-6 text-left">Nombre de Objetivo Estrategico</th>
                                    <th class="py-3 px-6 text-left">Indicador Estrategico</th>
                                    <th class="py-3 px-6 text-left">Nombre de Indicador Estrategico</th>
                                    <th class="py-3 px-6 text-left">Mes</th>
                                    <th class="py-3 px-6 text-left">Meta</th>
                                    <th class="py-3 px-6 text-left">Objetivos de ejecución</th>
                                    <th class="py-3 px-6 text-left">Porcentaje ejecución</th>
                                    <th class="py-3 px-6 text-left">Estado</th>
                                    <th class="py-3 px-6 text-left">Acción</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                <tr v-for="item in estateIndicators" :key="item.id" :class="{ 'bg-gray-100': item.status === 'Activo' }">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.get_indicator.name_indicator }}</td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.get_indicator.perspective }}</td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.get_indicator.name_perspective }}</td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.get_indicator.objective_strategy }}</td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.get_indicator.name_strategy }}</td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.get_indicator.indicator_strategy }}</td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.get_indicator.name_indicator_strategy }}</td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.month }}</td>
                                    <td class="py-3 px-6 text-left">{{ item.goal }}</td>
                                    <td class="py-3 px-6 text-left">{{ item.execution_goals }}</td>
                                    <td class="py-3 px-6 text-left">{{ Math.floor((item.execution_goals/item.goal)*100) }}%</td>
                                    <td class="py-3 px-6 text-left">{{ item.status }}</td>
                                    <td class="py-3 px-1 center">
                                       <div class="grid grid-cols-1 gap-1">
                                           <div class="col-auto">
                                               <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-if="item.cicly_indicator == 1 && $page.props.auth.user.role_id ==5" @click="goJustify(item)">
                                                   Justifcación
                                               </button>
                                           </div>

                                            <div class="col-auto">
                                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-if="item.cicly_indicator == 1 && $page.props.auth.user.role_id ==5">
                                                    Justifcación Control
                                                </button>
                                            </div>
                                       </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
