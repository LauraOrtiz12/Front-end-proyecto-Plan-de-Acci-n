<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';

defineProps({
  title: String,
});

const switchToTeam = (team) => {
  router.put(
    route('current-team.update'),
    {
      team_id: team.id,
    },
    {
      preserveState: false,
    }
  );
};

const logout = () => {
  router.post(route('logoutUser'));
};

let menu = ref(window.innerWidth > 768);

function toggleMenu() {
  menu.value = !menu.value;
}
</script>

<template>
  <div>
    <Head :title="title" />
    <Banner />
    <div class="min-h-screen bg-gray-100 flex">
      <div
        :class="[menu ? 'bg-menu backdrop-blur-sm h-screen lg:h-auto' : 'transparent', 'transition-all fixed w-screen z-10']"
        @click="toggleMenu"></div>
      <nav
        :class="[menu ? 'lg:sticky w-80' : 'w-20', 'fixed shadow-xl flex z-20 transition-all bg-secondary-default h-screen flex-col gap-5 top-0 overflow-y-auto py-0']">
        <img src="/assets/images/Group-780.svg" class="w-11 h-35 mr-2 z-10 " />
        <Link :href="route('dashboard')" class="">
          <ApplicationMark class="m-auto h-10 w-auto"/>
        </Link>
        <h1 class="font-bold text-primary-default text-center" v-if="menu">Plan de Acción</h1>
        <div class="flex flex-col gap-4 px-4">
          <h1 class="text-white bg-secondary-900 px-4 py-2 flex items-center">
            <img src="/assets/images/Group-774.svg" alt="Menú Principal" class="w-6 h-6 mr-2" />
            <span v-if="menu">Menú Principal</span>
          </h1>
          <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            <img src="/assets/images/8d4R33.tif.svg" alt="Menú Principal" class="fa-solid fa-house">
            <span v-if="menu"> Dash board</span>
            <hr>
          </NavLink>
          <hr>
          <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            <img src="/assets/images/Vigenica.svg" class="fa-solid fa-house">
            <span v-if="menu"> Validar vigencia</span>
            <hr>
          </NavLink>
          <hr>
          <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
            <img src="/assets/images/indicadores.svg" class="fa-solid fa-house">
            <span v-if="menu"> Observaciones y control</span>
            <hr>
          </NavLink>
          <hr>
          <NavLink :href="route('listValidities')" :active="route().current('listValidities')"
                   v-if="$page.props.auth.user.get_estate_indicator_responsability !== null ? Object.keys($page.props.auth.user.get_estate_indicator_responsability).length > 0 : false">
            <i class="fa-solid fa-list-check"></i>
            <span v-if="menu">Validar Vigencia</span>
          </NavLink>
          <NavLink :href="route('listValiditiesControl')" :active="route().current('listValiditiesControl')"
                   v-if="Object.keys($page.props.auth.user.get_estate_indicator_adviser).length > 0">
            <i class="fa-solid fa-list-check"></i>
            <span v-if="menu">Observacion - Control</span>
          </NavLink>
          <NavLink :href="route('gestionAdvisorOffices')" :active="route().current('gestionAdvisorOffices')"
                   v-if="Object.keys($page.props.auth.user.get_adviser_office).length > 0">
            <i class="fa-solid fa-list-check"></i>
            <span v-if="menu">Gestión de Asesor</span>
          </NavLink>
        </div>
        <div class="flex flex-col gap-4 px-4" v-if="$page.props.auth.user.role_id == 1">
          <h1 class="text-white bg-secondary-900 px-4 py-2 flex items-center">
            <img src="/assets/images/Group-775.svg" alt="Menú Principal" class="w-6 h-6 mr-2" />
            <span v-if="menu">Menú Administracion</span>
          </h1>
          <NavLink :href="route('listUsers')" :active="route().current('listUsers')">
            <img src="/assets/images/Group-776.svg" class="fa-solid fa-house">
            <span v-if="menu">Listar Usuarios</span>
            <hr>
          </NavLink>
          <hr>
          <NavLink :href="route('listEstates')" :active="route().current('listEstates')">
            <img src="/assets/images/dependencias.svg" class="fa-solid fa-house">
            <span v-if="menu"> Listar Dependencias</span>
            <hr>
          </NavLink>
          <hr>
          <NavLink :href="route('listIndicators')" :active="route().current('listIndicators')">
            <img src="/assets/images/Group-777.svg" class="fa-solid fa-house">
            <span v-if="menu"> Listar Indicadores</span>
            <hr>
          </NavLink>
          <hr>
          <NavLink :href="route('showCreateFollowUp')" :active="route().current('showCreateFollowUp')">
            <img src="/assets/images/Group-778.svg" class="fa-solid fa-house">
            <span v-if="menu"> Gestión de Seguimiento</span>
            <hr>
          </NavLink>
          <hr>
          <NavLink :href="route('showCreatePoll')" :active="route().current('showCreatePoll')"><i
            class="fa-solid fa-list"></i> Formularios
          </NavLink>
          <NavLink :href="route('showCreateShare')" :active="route().current('showCreateShare')"><i
            class="fa-solid fa-list"></i> Formularios
          </NavLink>
        </div>
        <button @click="logout" class="exit mt-auto mb-4 px-4 py-0 rounded-md mx-4">
          <img src="/assets/images/Group-128.svg" class="fa-solid fa-house w-10 h-15 mr-2 exit">
          Cerrar sesión
        </button>
      </nav>
      <main class="max-w-7xl w-full mx-auto p-4 gap-4 flex flex-col overflow-hidden">
        <div class="flex gap-4 justify-between">
          <div class="flex gap-4 items-center text-xl">
            <button @click="toggleMenu"
                    class="transition-all px-3 py-2 hover:bg-secondary-100 rounded-xl hover:shadow text-secondary-default">
              <i class="fa-solid fa-bars"></i>
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
                     alt="User Profile" />
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

<style>
.bg-menu {
  background-color: rgba(0, 0, 0, 0.5);
}
.nav-hidden {
  width: 5rem;
}
hr {
  border-top: 1px solid #ffffff;
  margin: 0;
  width: 100%;
}
.exit{
  background-color: #7C7C7C;
  color: #ffffff;
  font-size: 20px;
  margin-left: 10px;
}
</style>
