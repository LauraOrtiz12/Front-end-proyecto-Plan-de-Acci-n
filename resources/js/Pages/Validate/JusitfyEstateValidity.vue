<script setup>
import {useForm} from "@inertiajs/vue3";
import {defineProps} from "vue";
import Swal from "sweetalert2";

const props = defineProps({
    estates: Object,
    viability: Object,
    followUp: Object,
    cicle: {
        type: Number,
        default: 2
    }
})

const emit = defineEmits(['close']);

const form = useForm({
    estate_indicator_id: props.estates.id,
    validity_id: props.viability,
    cicle: Object.keys(props.followUp).length == 0 ? 2 : props.cicle,
    justify_estate_indicator: null,
    justify_estate_money: null,
});

const closeEmit = () => {
    emit('close');
}

const save = () => {
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
            form.post('setFollowUp', {
                onSuccess: (res) => {
                    console.log(res.props.followUp[0].id)
                    Swal.fire({
                        title: 'Éxito',
                        text: 'El formulario se ha enviado correctamente. Su Registro es: ' + res.props.followUp[0].id,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar',
                        target: "#justifyForModal"
                    }).then(() => {
                        // Restablecer el formulario después de cerrar la alerta
                        form.reset();
                        emit('close');
                    });
                }
            });
        }
    });
}
</script>

<template>
    <div>
        <div class=" bg-white rounded-lg shadow-lg p-6" id="justifyForModal">
            <h2 class="text-xl font-semibold mb-4">Justificación de la Dependencia</h2>
            <form action="" method="post">

                <div class="mb-4">
                    <label for="justify_estate_indicator" class="block mb-2 font-bold">Justificación del plan por parte
                        de la dependencia (Indicadores)</label>
                    <textarea name="justify_estate_indicator" id="justify_estate_indicator"
                              class="w-full px-3 py-2 border rounded-md"
                              v-model="form.justify_estate_indicator"></textarea>
                    Longitud: {{ form.justify_estate_indicator == null ? 0 : form.justify_estate_indicator.length }}
                    <div class="error-message bg-red-500 text-white rounded p-1 text-sm"
                         v-if="form.errors.justify_estate_indicator">{{ form.errors.justify_estate_indicator }}
                    </div>
                </div>
                <div class="mb-4">
                    <label for="justify_estate_money" class="block mb-2">Justificación del plan por parte de la
                        dependencia (Presupuesto)</label>
                    <textarea name="justify_estate_money" id="justify_estate_money"
                              class="w-full px-3 py-2 border rounded-md" required
                              v-model="form.justify_estate_money"></textarea>
                    Longitud: {{ form.justify_estate_money == null ? 0 : form.justify_estate_money.length }}
                    <div class="error-message bg-red-500 text-white rounded p-1 text-sm"
                         v-if="form.errors.justify_estate_money">{{ form.errors.justify_estate_money }}
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="flex justify-end mx-2">
                        <button type="button"
                                class="flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-md"
                                @click="closeEmit">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7"></path>
                            </svg>
                            Cerrar
                        </button>
                    </div>
                    <div class="flex justify-end">
                        <button type="button"
                                class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md"
                                @click="save">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7"></path>
                            </svg>
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
