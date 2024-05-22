<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
// import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logoutUser'));
};
</script>

<template>
    <div>

        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 flex">
            <nav class="bg-white shadow-md w-64 h-screen p-4 flex flex-col gap-4 sticky top-0">
                <Link :href="route('dashboard')">
                <ApplicationMark class="m-auto h-10 w-auto" />
                </Link>
                <h1 class="text-center text-balance font-bold text-secondary-default">Plan Anual de Adquisición</h1>
                <hr class>
                <div class="flex flex-col p-4 bg-gray-100 rounded-xl gap-4">
                    <h1 class="text-gray-500 border-b">Menú Principal</h1>
                    <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</NavLink>
                    <NavLink :href="route('listValidities')" :active="route().current('listValidities')">Validar
                        Vigencia</NavLink>
                </div>

                <div class="flex flex-col p-4 bg-gray-100 rounded-xl gap-4" v-if="$page.props.auth.user.role_id == 1">
                    <h1 class="text-gray-500 border-b">Menú Administración</h1>
                    <NavLink :href="route('listUsers')" :active="route().current('listUsers')">Listar Usuarios</NavLink>
                    <NavLink :href="route('listEstates')" :active="route().current('listEstates')">Listar Dependencias
                    </NavLink>
                    <NavLink :href="route('listIndicators')" :active="route().current('listIndicators')">Listar
                        Indicadores</NavLink>
                </div>
            </nav>

            <main class="max-w-7xl w-full mx-auto p-4 gap-4 flex flex-col">
                <div class="flex gap-4 justify-between">
                    <slot name="header" />
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button
                                class="transition-all hover:bg-secondary-100 rounded-xl hover:shadow px-2 py-1 text-secondary-default font-bold flex items-center gap-3">
                                ¡Hola {{ $page.props.auth.user.name }}!
                                <img class="w-auto h-10 shadow rounded-full"
                                    :src="$page.props.auth.user.profile_photo_url ? $page.props.auth.user.profile_photo_url : 'https://ui-avatars.com/api/?background=ffff&name={{$page.props.auth.user.name}}'"
                                    alt="User Profile">
                                <i class="fa-solid fa-angle-down"></i>
                            </button>
                            <!-- <button v-if="$page.props.jetstream.managesProfilePhotos"
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover"
                                    :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </button> -->

                        </template>

                        <template #content>
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Administración
                            </div>

                            <DropdownLink :href="route('profile.show')">
                                Perfil
                            </DropdownLink>

                            <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                API Tokens
                            </DropdownLink>

                            <div class="border-t border-gray-200" />

                            <!-- Authentication -->
                            <form @submit.prevent="logout">
                                <DropdownLink as="button">
                                    Salir
                                </DropdownLink>
                            </form>
                        </template>
                    </Dropdown>

                </div>
                <slot />
            </main>
        </div>
    </div>
</template>
