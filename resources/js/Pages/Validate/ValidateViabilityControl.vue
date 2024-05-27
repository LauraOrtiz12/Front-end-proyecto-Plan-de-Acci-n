<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from 'vue';
import {router} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import JusitfyEstateValidity from "@/Pages/Validate/JusitfyEstateValidity.vue";
import Swal from "sweetalert2";

const props = defineProps({
    followUp: Object,
    viability: Object,
    estates: Object,
    estatesControl: Object,
    user: Object
});

const validity = ref('');
const estateIndicators = ref([]);
const estateIndicatorsAdviser = ref([]);
const followUp = ref({});
const showModalJustifyOne = ref(false);
const cicle = ref(1);
const followUps = ref();
const justifyControl = ref('');
const loadViabilityControl = () => {
    const adviser = props.user.get_estate_indicator_adviser.map(res => res.id);
    axios.get('getDataAdviser', {params: {validity: validity.value, adviser: adviser}})
        .then((response) => {
            estateIndicatorsAdviser.value = response.data.indicator;
            followUps.value = response.data.followups;
        });


    /*axios.get('estateIndicatorsAdviser', { params: { validity: validity.value } })
        .then((response) => estateIndicatorsAdviser.value = response.data)

    axios.get('estateIndicators', { params: { validity: validity.value } })
        .then((response) => estateIndicators.value = response.data);

    axios.get('getFollowUp', { params: { validity: validity.value } })
        .then((response) => followUp.value = response.data);*/

}

const goJustify = (item) => {
    router.get('justify/indicator', item)
}

const openJustifyOne = () => {
    showModalJustifyOne.value = !showModalJustifyOne.value;
}
const closeJustifyOne = () => {
    loadViabilityControl();
    showModalJustifyOne.value = !showModalJustifyOne.value;
}

const update = (item) => {
const text = document.getElementById("updateJustify"+item.id).value;
if(text.length == 0){
    Swal.fire({
        title: 'Error',
        text: 'Los Campos son Obligatorios',
        icon: 'error',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Cerrar',
        target: "#justifyForModal"
    });
    return 0;
}
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
            axios.post('updateFollowUp', { id: item.id, observation_control: text })
                .then((response) => {
                    loadViabilityControl();
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Se ha actualizado correctamente: ',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar',
                        target: "#justifyForModal"
                    })
                });


        }
    });



};
</script>
<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">Vigencia (Seguimiento)</h1>
        </template>
        <div class="flex flex-col gap-4">
            <div class="flex items-center">
                <span class="flex items-center mr-2 bg-secondary-default px-3 py-1 rounded-lg text-white"><img
                    src="assets/images/vigencia.webp" alt="" width="35px">Vigencia</span>
                <select
                    class="block w-40 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    name="viability" id="viability" v-model="validity">
                    <option :value="via.id" v-for="via in viability" :key="via.id">{{ via.validity }}</option>
                </select>
                <button @click="loadViabilityControl"
                        class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        v-if="Object.keys($page.props.estatesControl).length > 0 || Object.keys($page.props.estates).length > 0">
                    Validar
                </button>
            </div>
            <div class="flex flex-wrap lg:flex-nowrap gap-3 shadow p-3 rounded-md bg-white"
                 v-if="$page.props.auth.user.role_id == 3 || $page.props.auth.user.role_id == 4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Información de Usuario</h3>
                </div>
                <dl class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Nombre:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ $page.props.auth.user.name }}</dd>
                    </div>
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Correo Electrónico:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ $page.props.auth.user.email }}</dd>
                    </div>
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Rol:</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2">{{ $page.props.user.get_role.rol }}</dd>
                    </div>
                    <div class="bg-gray-100 rounded-md px-5 py-4 grid md:grid-cols-3 gap-3 overflow-hidden">
                        <dt class="text-sm font-medium text-gray-800">Dependencia(s):</dt>
                        <dd class="mt-1 text-sm text-gray-500 sm:col-span-2"
                            v-for="dependence in $page.props.user.get_estate_indicator_adviser"> {{ dependence.id }}-
                            {{ dependence.dependence }}
                        </dd>
                    </div>
                </dl>
            </div>
            <div v-else class="text-center bg-white mt-1">
                <span>No Tiene Asociado una dependencia</span>
            </div>

            <div class="container">
                <div>
                    <table class="table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Cod Dependencia</th>
                            <th class="py-3 px-6 text-left">Estado</th>
                            <th class="py-3 px-6 text-left">Justificación de Indicadores</th>
                            <th class="py-3 px-6 text-left">Justifiación Presupuestal</th>
                            <th class="py-3 px-6 text-left">Fecha</th>
                            <th class="py-3 px-6 text-left">Justificación de Seguimiento</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr v-for="item in followUps" :key="item.id"
                            :class="{ 'bg-gray-100': item.status === 'Activo' }">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.estate_id }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.justify_status }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.justify_estate_indicator }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.justify_estate_money }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.created_at }}</td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="grid grid-cols-1 gap-3">
                                    <textarea :name="`updateJustify`+item.id" :id="`updateJustify`+item.id" cols="30" rows="5"
                                              class="w-full px-3 py-2 border rounded-md"></textarea>
                                    <button @click="update(item)"
                                            class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                            v-if="Object.keys($page.props.estatesControl).length > 0 || Object.keys($page.props.estates).length > 0">
                                        Guardar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="w-full mt-4"
                 v-if="$page.props.auth.user.role_id != 2 && Object.keys(estateIndicatorsAdviser).length > 0">
                Indicadores
                <div class="grid grid-cols-1 gap-2">

                    <div class="bg-white mx-8 shadow overflow-x-auto sm:rounded-lg px-3">
                        <div class="container mx-1 ">
                            <div class="bg-white shadow-md rounded my-6">
                                <table class="table-auto">
                                    <thead>
                                    <tr>
                                        <th colspan="13">Control de Indicadores</th>
                                    </tr>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">Cod Regional</th>
                                        <th class="py-3 px-6 text-left">Cod Dependencia</th>
                                        <th class="py-3 px-6 text-left">Dependencia</th>
                                        <th class="py-3 px-6 text-left">Nombre de Indicador</th>

                                        <th class="py-3 px-6 text-left">Nombre de Perspectiva</th>

                                        <th class="py-3 px-6 text-left">Nombre de Objetivo Estrategico</th>

                                        <th class="py-3 px-6 text-left">Nombre de Indicador Estrategico</th>
                                        <th class="py-3 px-6 text-left">Mes</th>
                                        <th class="py-3 px-6 text-left">Meta</th>
                                        <th class="py-3 px-6 text-left">Objetivos de ejecución</th>
                                        <th class="py-3 px-6 text-left">Porcentaje ejecución</th>
                                        <th class="py-3 px-6 text-left">Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm font-light">
                                    <tr v-for="item in estateIndicatorsAdviser" :key="item.id"
                                        :class="{ 'bg-gray-100': item.status === 'Activo' }">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_estate.cod_reg
                                            }}
                                        </td>
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_estate.cod_dep
                                            }}
                                        </td>
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_estate.dependence
                                            }}
                                        </td>
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_indicator.name_indicator
                                            }}
                                        </td>

                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_indicator.name_perspective
                                            }}
                                        </td>

                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_indicator.name_strategy
                                            }}
                                        </td>

                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{
                                                item.get_indicator.name_indicator_strategy
                                            }}
                                        </td>
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ item.month }}</td>
                                        <td class="py-3 px-6 text-left">{{ item.goal }}</td>
                                        <td class="py-3 px-6 text-left">{{ item.execution_goals }}</td>
                                        <td class="py-3 px-6 text-left">{{
                                                parseFloat((item.execution_goals / item.goal) * 100).toFixed(2)
                                            }}%
                                        </td>
                                        <td class="py-3 px-6 text-left">{{ item.status }}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Modal :show="showModalJustifyOne" maxWidth="w-full" :closeable="true">
                <JusitfyEstateValidity :viability="validity" :estates="estates" :followUp="followUp" :cicle="cicle"
                                       @close="closeJustifyOne"></JusitfyEstateValidity>
            </Modal>
        </div>

    </AppLayout>
</template>
