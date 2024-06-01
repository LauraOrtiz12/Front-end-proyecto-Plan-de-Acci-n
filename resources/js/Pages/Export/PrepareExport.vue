<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    viability: Object,
});

const viabilityExport = () => {

}
</script>
<template>
    <AppLayout>

        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">Exportar</h1>
        </template>
        <div class="flex flex-col gap-4" >
            <div class="flex items-center">
                <span class="flex items-center mr-2 bg-secondary-default px-3 py-1 rounded-lg text-white"><img src="assets/images/vigencia.webp" alt="" width="35px">Vigencia</span>
                <select class="block w-40 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" name="viability" id="viability" v-model="validity">
                    <option :value="via.id" v-for="via in viability" :key="via.id">{{via.validity}}</option>
                </select>


                <button @click="viabilityExport"
                        class="ml-3 inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                       >
                    Generar Excel
                </button>
            </div>
        </div>
    </AppLayout>
</template>
