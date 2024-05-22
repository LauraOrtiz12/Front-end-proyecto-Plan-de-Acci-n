<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'text-sm py-2 px-3 text-secondary-default transition-all border-2 border-secondary-default rounded-xl bg-secondary-default text-white'
        : 'text-sm py-2 px-3 text-secondary-default transition-all border-secondary-default hover:bg-secondary-100 rounded-xl';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
