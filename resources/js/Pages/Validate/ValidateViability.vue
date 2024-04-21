<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    viability: Object,
    estates: Object
})
</script>
<template>
    <AppLayout>
        <template #header>
            <div class="flex items-center">
                <span class="mr-2">Vigencia</span>
                <select class="block w-40 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="viability" id="viability">
                    <option :value="via.validity" v-for="via in viability" :key="via.id">{{via.validity}}</option>
                </select>
                <button class="ml-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Validar
                </button>
            </div>
        </template>
        <div class="mt-4">
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
    </AppLayout>
</template>
