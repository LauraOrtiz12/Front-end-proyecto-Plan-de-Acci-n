<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'transition-all text-sm py-2 ml-4 px-3 text-white rounded-l border-l-8 border-primary-default bg-primary-700 '
        : 'transition-all text-sm py-2 ml-4 px-3 text-secondary-100 hover:rounded-l hover:border-l-8 border-secondary-900 hover:text-secondary-default hover:bg-secondary-200';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
