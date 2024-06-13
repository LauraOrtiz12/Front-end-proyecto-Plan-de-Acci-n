<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    icon: {
        type: String,
        default: '',  
    },
    variant: {
        type: String,
        default: 'primary',
    },
});

const buttonClasses = computed(() => {
    const classesMap = {
        login: 'bg-primary-default text-white hover:bg-primary-700',
        warning: 'bg-yellow-500 text-white hover:bg-yellow-600',
        info: 'bg-blue-500 text-white hover:bg-blue-600',
        success: 'bg-green-500 text-white hover:bg-green-600',
        danger: 'bg-red-500 text-white hover:bg-red-600',
        secondary: 'bg-gray-200 text-secondary-default hover:bg-secondary-default hover:text-white',
        primary: 'bg-gray-200 text-secondary-default hover:bg-primary-default hover:text-white',
    };

    return classesMap[props.variant] || '';
});
</script>

<template>
    <button :type="type" :class="['transition-all py-2 px-6 rounded-md font-bold w-fit hover:shadow-md', buttonClasses]">
        <i v-if="icon" :class="icon"></i>
        <slot />
    </button>
</template>

