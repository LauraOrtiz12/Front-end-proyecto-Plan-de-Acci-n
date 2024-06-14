<script setup>
import { computed } from 'vue';

// Define las props del componente
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

// Define las clases del botón según la prop variant
const buttonClasses = computed(() => {
    // Clase base del botón
    const baseClass = 'transition-all py-2 px-6 rounded-md font-bold w-fit ';
    
    // Mapa de las clases según la prop variant
    const variantMap = {
        login: 'bg-primary-default text-white hover:bg-primary-700',
        warning: 'bg-yellow-500 text-white hover:bg-yellow-600',
        info: 'bg-blue-500 text-white hover:bg-blue-600',
        success: 'bg-green-500 text-white hover:bg-green-600',
        danger: 'bg-red-500 text-white hover:bg-red-600',
        secondary: 'bg-gray-200 text-secondary-default hover:bg-secondary-default hover:text-white',
        primary: 'bg-gray-200 text-secondary-default hover:bg-primary-default hover:text-white',
    };

    // Retorna la clase del botón concatenando la clase base y la clase del mapa según la prop variant
    return `${baseClass}${variantMap[props.variant] || ''}`;
});
</script>

<template>
    <!-- Renderiza el botón con las clases definidas -->
    <button :type="type" :class="buttonClasses">
        <!-- Renderiza el ícono si se proporciona la prop icon -->
        <i v-if="icon" :class="icon"></i>
        <!-- Renderiza el contenido del slot -->
        <slot />
    </button>
</template>