<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from "@/Layouts/AppLayout.vue";
import Swal from 'sweetalert2';
import { ref, defineProps } from 'vue';


const traducirClave = (key) => {
    const traducciones = {
        cicly_indicator: 'Indicador de Ciclo',
        created_at: 'Fecha de Creación',
        estate_id: 'ID de Estado',
        execution_goals: 'Metas de Ejecución',
        get_indicator: 'Indicador Obtenido',
        goal: 'Meta',
        id: 'ID',
        indicator_id: 'ID de Indicador',
        month: 'Mes',
        name_indicator: 'Nombre del Indicador',
        name_perspective: 'Nombre de la Perspectiva',
        name_strategy: 'Nombre de la Estrategia',
        perspective: 'Perspectiva',
        status: 'Estado',
        updated_at: 'Fecha de Actualización',
        validity_id: 'ID de Validez',
        objective_strategy: 'Objetivo de Estrategico',
        indicator_strategy: 'Indicador Estrategico',
        name_indicator_strategy : 'Nombre de Indicador Estrategico'
    };

    return traducciones[key] || key;
}

// Define props using defineProps
const props = defineProps({
    params: {
        type: Object,
        required: true
    },
    dataIndicator:{
        type: Object
    },
    user:{
        type: Object
    }
});


const form = useForm({
    estate_indicator_id: props.params.id,
    observation_goal: null,
    justification_goals_budget : null,
    initial_date: null,
    final_date: null,
    physical_resource: null,
    technical_resource: null,
    human_resource: null
})


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
            form.post('/justify/indicator', {
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
    <AppLayout>
        <template #header>
            <div class="flex items-center">
                <span class="mr-2">Justificación de Indicador</span>
            </div>
        </template>

        <div class=" mx-4 py-8">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre del Parámetro</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre del Parámetro</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('month') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.month}}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('name_indicator') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.get_indicator.name_indicator }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('goal') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.goal}}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('execution_goals') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.execution_goals }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('perspective') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.get_indicator.perspective }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('name_perspective') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.get_indicator.name_perspective }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('objective_strategy') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.get_indicator.objective_strategy }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('name_strategy') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.get_indicator.name_strategy }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('indicator_strategy') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.get_indicator.indicator_strategy }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-1/4 whitespace-nowrap">{{ traducirClave('name_indicator_strategy') }}</td>
                        <td class="px-6 py-4 sm:w-1/2 md:w-3/4 whitespace-nowrap">{{ $page.props.params.get_indicator.name_indicator_strategy }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 mx-4 my-1 w-full" v-if="Object.keys(dataIndicator).length > 0">
            <div v-for="dt in dataIndicator" :key="dt.id" class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-4">
                    <div class="font-bold">
                        {{dt.who_user_cicly_one.name}} / {{dt.who_user_cicly_one.get_role.rol}}
                    </div>
                    <div class="mb-2 col-auto">
                        <span class="font-bold">Justificación de Meta:</span> {{ dt.observation_goal }}
                    </div>
                    <div class="mb-2 col-auto">
                        <span class="font-bold">Justificación de Meta Propuesta:</span>
                        {{ dt.justification_goals_budget }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Fecha Inicial:</span> {{ dt.initial_date }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Fecha Final:</span> {{ dt.final_date }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Recurso Físico:</span> {{ dt.physical_resource }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Recurso Técnico:</span> {{ dt.technical_resource }}
                    </div>
                    <div class="mb-2">
                        <span class="font-bold">Recurso Humano:</span> {{ dt.human_resource }}
                    </div>
                </div>
            </div>
        </div>


        <div class="mx-4" v-if="$page.props.params.cicly_indicator == 1 && $page.props.params.get_estate.responsible_id == $page.props.user.id">
            <div class=" bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Justificación</h2>
                <form action="" method="post">
                    <input type="hidden" name="id" id="id"  v-model="form.estate_indicator_id" >
                    <div class="mb-4">
                        <label for="observation_goal" class="block mb-2 font-bold">Justificación de Meta</label>
                        <input type="text" name="observation_goal" id="observation_goal" class="w-full px-3 py-2 border rounded-md" v-model="form.observation_goal">
                        <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.observation_goal">{{ form.errors.observation_goal }}</div>
                    </div>
                    <div class="mb-4">
                        <label for="justification_goals_budget" class="block mb-2">Justificación de Meta Propuesta</label>
                        <input type="text" name="justification_goals_budget" id="justification_goals_budget" class="w-full px-3 py-2 border rounded-md" required v-model="form.justification_goals_budget">
                        <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.justification_goals_budget">{{ form.errors.justification_goals_budget }}</div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="mb-4">
                            <label for="initial_date" class="block mb-2">Fecha Inicial</label>
                            <input type="date" name="initial_date" id="initial_date" class="w-full px-3 py-2 border rounded-md" v-model="form.initial_date">
                            <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.initial_date">{{ form.errors.initial_date }}</div>
                        </div>
                        <div class="mb-4">
                            <label for="final_date" class="block mb-2">Fecha Fin</label>
                            <input type="date" name="final_date" id="final_date" class="w-full px-3 py-2 border rounded-md" v-model="form.final_date">
                            <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.final_date">{{ form.errors.final_date }}</div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="physical_resource" class="block mb-2">Recurso Físico</label>
                        <input type="text" name="physical_resource" id="physical_resource" class="w-full px-3 py-2 border rounded-md" v-model="form.physical_resource">
                        <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.physical_resource">{{ form.errors.physical_resource }}</div>
                    </div>
                    <div class="mb-4">
                        <label for="technical_resource" class="block mb-2">Recurso Técnico</label>
                        <input type="text" name="technical_resource" id="technical_resource" class="w-full px-3 py-2 border rounded-md" v-model="form.technical_resource">
                        <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.technical_resource">{{ form.errors.technical_resource }}</div>
                    </div>
                    <div class="mb-6">
                        <label for="human_resource" class="block mb-2">Recurso Humano</label>
                        <input type="text" name="human_resource" id="human_resource" class="w-full px-3 py-2 border rounded-md" v-model="form.human_resource">
                        <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.human_resource">{{ form.errors.human_resource }}</div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md" @click="save">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <div class=" mx-4 py-8" v-if="$page.props.params.cicly_indicator == 2 && $page.props.params.get_estate.adviser_id == $page.props.user.id">
            <div class=" bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Seguimiento</h2>
                <form action="" method="post">

                    <input type="hidden" name="id" id="id"  v-model="form.estate_indicator_id" >
                    <div class="mb-4">
                        <label for="follow_up_observation" class="block mb-2">Seguimiento y Observación</label>
                        <input type="text" name="follow_up_observation" id="follow_up_observation" class="w-full px-3 py-2 border rounded-md" v-model="form.observation_goal">
                        <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.observation_goal">{{ form.errors.observation_goal }}</div>
                    </div>
                    <div class="mb-4">
                        <label for="follow_up_justify_indicator" class="block mb-2">Seguimiento de Justificación de Meta Propuesta</label>
                        <input type="text" name="follow_up_justify_indicator" id="follow_up_justify_indicator" class="w-full px-3 py-2 border rounded-md" required v-model="form.justification_goals_budget">
                        <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.justification_goals_budget">{{ form.errors.justification_goals_budget }}</div>
                    </div>

                    <div class="mb-4">
                        <label for="justification_monitoring_budget" class="block mb-2">Justificación de Monitoreo Propuesto</label>
                        <input type="text" name="justification_monitoring_budget" id="justification_monitoring_budget" class="w-full px-3 py-2 border rounded-md" v-model="form.physical_resource">
                        <div class="error-message bg-red-500 text-white rounded p-1 text-sm" v-if="form.errors.physical_resource">{{ form.errors.physical_resource }}</div>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md" @click="save">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>



    </AppLayout>
</template>
