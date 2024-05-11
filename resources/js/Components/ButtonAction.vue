<script setup>
import { router } from '@inertiajs/vue3'
const onEdit = (id) => {
    router.visit('/listEstates?edit='+ id, { method: 'get' })
    //Inertia.visit('/listEstates?edit='+ id);
    //router.push({ path: '/listEstates', query: { id } });
};

</script>

<template>
    <button @click="onEdit(this.params.value)" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M14.293 4.293a1 1 0 0 1 1.414 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.287-1.287l1-3a1 1 0 0 1 .242-.39l9-9z" clip-rule="evenodd" />
            <path fill-rule="evenodd" d="M13 3a1 1 0 0 1 1 1v4c0 .265-.105.52-.293.707L6.414 17H3a1 1 0 1 1 0-2h3.586l7.293-7.293c.187-.188.293-.442.293-.707V3z" clip-rule="evenodd" />
        </svg>
    </button>
</template>
