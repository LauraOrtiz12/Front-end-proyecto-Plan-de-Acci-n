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

let menu = window.innerWidth > 768 ? ref(true) : ref(false);

function toggleMenu() {
    menu.value = !menu.value;
};

</script>

<template>
    <div>

        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 flex " >
            <div :class="[menu ? 'bg-black opacity-50 h-screen md:h-auto':'transparent', 'transition-all fixed w-screen z-10']" @click="menu ? toggleMenu():''"></div>
            <nav
                :class="[menu ? 'fixed lg:sticky' : 'absolute -translate-x-full', 'flex z-20 transition-all bg-white shadow-md w-64 h-screen p-4 flex-col gap-4 top-0']">
                <Link :href="route('dashboard')">
                <ApplicationMark class="m-auto h-10 w-auto" />
                </Link>
                <h1 class="text-center text-balance font-bold text-primary-default">Plan Anual de Adquisición</h1>
                <hr class>
                <div class="flex flex-col p-4 bg-gray-100 rounded-xl gap-4">
                    <h1 class="text-gray-500 border-b">Menú Principal</h1>
                    <NavLink :href="route('dashboard')" :active="route().current('dashboard')"><i
                            class="fa-solid fa-house"></i> Dashboard</NavLink>
                    <NavLink :href="route('listValidities')" :active="route().current('listValidities')"><i
                            class="fa-solid fa-list-check"></i> Validar
                        Vigencia</NavLink>
                </div>

                <div class="flex flex-col p-4 bg-gray-100 rounded-xl gap-4" v-if="$page.props.auth.user.role_id == 1">
                    <h1 class="text-gray-500 border-b">Menú Administración</h1>
                    <NavLink :href="route('listUsers')" :active="route().current('listUsers')"><i
                            class="fa-solid fa-list"></i> Listar Usuarios</NavLink>
                    <NavLink :href="route('listEstates')" :active="route().current('listEstates')"><i
                            class="fa-solid fa-list"></i> Listar Dependencias
                    </NavLink>
                    <NavLink :href="route('listIndicators')" :active="route().current('listIndicators')"><i
                            class="fa-solid fa-list"></i> Listar
                        Indicadores</NavLink>
                </div>
                <!-- <img src="assets/images/login-background-overlay.webp" alt=""
                class="object-cover transition-all duration-1000 absolute w-auto h-20" /> -->
            </nav>

            <main class="transition-all max-w-7xl w-full mx-auto p-4 gap-4 flex flex-col">
                <div class="flex gap-4 justify-between">
                    <div class="flex gap-4 items-center text-xl">
                        <button @click="toggleMenu"
                            class="transition-all px-3 py-2 hover:bg-secondary-100 rounded-xl hover:shadow text-secondary-default">
                            <i class="fa-solid fa-bars "></i>
                        </button>
                        <slot name="header" />
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
