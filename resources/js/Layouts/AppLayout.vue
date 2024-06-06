<script setup>
import {ref} from 'vue';
import {Head, Link, router} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';

defineProps({
    title: String,
});
// const showingNavigationDropdown = ref(false);
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

let menu = window.innerWidth > 768 ? ref(true) : ref(false);

function toggleMenu() {
    menu.value = !menu.value;
};
</script>
<template>
    <div>
        <Head :title="title"/>
        <Banner/>
        <div class="min-h-screen bg-gray-100 flex">
            <div
                :class="[menu ? 'bg-menu backdrop-blur-sm h-screen lg:h-auto' : 'transparent', 'transition-all fixed w-screen z-10']"
                @click="toggleMenu"></div>
            <nav
                :class="[menu ? 'lg:sticky' : '-translate-x-full', 'fixed shadow-xl flex z-20 transition-all bg-secondary-default min-w-64 w-64 h-screen flex-col gap-4 top-0 overflow-y-auto py-4']">
                <Link :href="route('dashboard')">
                    <ApplicationMark class="m-auto h-10 w-auto"/>
                </Link>
                <h1 class="font-bold text-primary-default text-center">Plan de Acción</h1>
                <div class="flex flex-col gap-4">
                    <h1 class="text-white bg-secondary-900 px-4 py-2">Menú Principal</h1>
                    <NavLink :href="route('dashboard')" :active="route().current('dashboard')"><i
                        class="fa-solid fa-house"></i> Dashboard
                    </NavLink>
                    <NavLink :href="route('listValidities')" :active="route().current('listValidities')"
                             v-if="$page.props.auth.user.get_estate_indicator_responsability !==  null ? Object.keys($page.props.auth.user.get_estate_indicator_responsability).length > 0 : false">
                        <i class="fa-solid fa-list-check"></i>
                        Validar Vigencia
                    </NavLink>
                    <NavLink :href="route('listValiditiesControl')" :active="route().current('listValiditiesControl')"
                             v-if="Object.keys($page.props.auth.user.get_estate_indicator_adviser).length > 0"><i
                        class="fa-solid fa-list-check"></i> Observacion - Control
                    </NavLink>
                    <NavLink :href="route('gestionAdvisorOffices')" :active="route().current('gestionAdvisorOffices')"
                             v-if="Object.keys($page.props.auth.user.get_adviser_office).length > 0"><i
                        class="fa-solid fa-list-check"></i> Gestión de Asesor
                    </NavLink>
                </div>
                <div class="flex flex-col gap-4" v-if="$page.props.auth.user.role_id == 1">
                    <h1 class="text-white bg-secondary-900 px-4 py-2">Menú Administración</h1>
                    <NavLink :href="route('listUsers')" :active="route().current('listUsers')"><i
                        class="fa-solid fa-list"></i> Listar Usuarios
                    </NavLink>
                    <NavLink :href="route('listEstates')" :active="route().current('listEstates')"><i
                        class="fa-solid fa-list"></i> Listar Dependencias
                    </NavLink>
                    <NavLink :href="route('listIndicators')" :active="route().current('listIndicators')"><i
                        class="fa-solid fa-list"></i> Listar
                        Indicadores
                    </NavLink>
                    <NavLink :href="route('showCreateFollowUp')" :active="route().current('showCreateFollowUp')"><i
                        class="fa-solid fa-list"></i> Gestión Seguimiento
                    </NavLink>
                </div>
                <span class="lg:hidden text-balance text-xs text-center text-gray-600 animate-pulse">Toca fuera del menú
                    para cerrarlo.</span>
                <!-- <img src="assets/images/login-background-overlay.webp" alt=""
                class="object-cover transition-all duration-1000 absolute w-auto h-20" /> -->
            </nav>
            <main class="max-w-7xl w-full mx-auto p-4 gap-4 flex flex-col overflow-hidden">
                <div class="flex gap-4 justify-between">
                    <div class="flex gap-4 items-center text-xl">
                        <button @click="toggleMenu"
                                class="transition-all px-3 py-2 hover:bg-secondary-100 rounded-xl hover:shadow text-secondary-default">
                            <i class="fa-solid fa-bars "></i>
                        </button>
                        <slot name="header"/>
                    </div>
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button
                                class="transition-all hover:bg-secondary-100 rounded-xl hover:shadow px-2 py-1 text-secondary-default font-bold flex items-center gap-3">
                                <span class="hidden md:block">¡Hola {{ $page.props.auth.user.name }}!</span>
                                <img class="w-auto h-10 shadow rounded-full"
                                     :src="$page.props.auth.user.profile_photo_url ? $page.props.auth.user.profile_photo_url : 'https://ui-avatars.com/api/?background=ffff&name={{$page.props.auth.user.name}}'"
                                     alt="User Profile">
                                <i class="fa-solid fa-angle-down"></i>
                            </button>
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
                            <div class="border-t border-gray-200"/>
                            <!-- Authentication -->
                            <form @submit.prevent="logout">
                                <DropdownLink as="button">
                                    Salir
                                </DropdownLink>
                            </form>
                        </template>
                    </Dropdown>
                </div>
                <slot/>
            </main>
        </div>
    </div>
</template>
<style>
.bg-menu {
    background-color: rgba(0, 0, 0, 0.5);
}
</style>
