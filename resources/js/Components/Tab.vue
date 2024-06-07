<script setup>

import {ref} from "vue";
const tab = ref(1);
</script>
<template>
    <div class="overflow-hidden bg-white shadow-md rounded-lg">
        <!-- Tabs -->
        <div class="flex border-b">
            <label for="tab1" :class="[tab == 1 ? 'border-b-4 border-primary-700 bg-primary-default text-white' : 'hover:border-b-4 text-secondary-default hover:bg-secondary-200 hover:border-secondary-default hover:border-secpndary-default ', 'tab-label py-2 px-4 cursor-pointer  ']" @click="tab = 1">Indicadores de Gestión</label>
            <label for="tab1" :class="[tab == 2 ? 'border-b-4 border-primary-700 bg-primary-default text-white' : 'hover:border-b-4 text-secondary-default hover:bg-secondary-200 hover:border-secondary-default hover:border-secpndary-default ', 'tab-label py-2 px-4 cursor-pointer ']" @click="tab = 2">Indicadores de Prespuesto</label>
        </div>
        <div id="content1" :class="[tab == 1 ? '' : 'hidden', 'tab-content p-4']">
            <slot name="t1"/>
        </div>
        <div id="content2" :class="[tab == 2 ? '' : 'hidden', 'tab-content p-4']">
            <slot name="t2"/>
        </div>
    </div>
</template>
<style scoped>
.tab-label {
    transition: all 0.3s ease;
}
</style>
