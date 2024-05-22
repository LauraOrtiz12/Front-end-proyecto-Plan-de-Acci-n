<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import Register from "@/Pages/Auth/Register.vue";
import {router} from '@inertiajs/vue3'
import ListEstatesAssoc from "@/Pages/Estate/ListEstatesAssoc.vue";


defineProps({
    role: Array,
    estates : Object
});

const newUserModal = ref(false);
const assocAdviser = ref(false);
const userSelect = ref(null);

const close = () => {
    newUserModal.value = false;
    router.reload({only: ['users']})

}
const openAssocAdviser = (user) => {
    userSelect.value = user;
    assocAdviser.value = !assocAdviser.value;
}
</script>
<template>
    <AppLayout>
        
        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">Lista de Usuarios</h1>
        </template>

        <div class="">
            <div class="py-6">
                <button @click="newUserModal = !newUserModal"
                        class="inline-flex items-center px-4 py-2 bg-primary-default border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-user-plus mr-1"></i>
                    Nuevo Usuario
                </button>
            </div>
            <div class="overflow-x-auto rounded-xl shadow-md">
                <table class="w-full min-w-[970px] overflow-hidden table-fixed">
                    <thead class="bg-secondary-default text-white uppercase text-xs tracking-wider whitespace-nowrap">
                    <tr>
                        <th scope="col" class="px-6 py-4">
                            <div class="flex items-center flex-nowrap gap-3">
                                <img class="align-middle" src="assets/images/ID.webp" alt="" width="35px">
                                ID
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4">
                            <div class="flex items-center flex-nowrap gap-3">
                                <img class="align-middle" src="assets/images/nombre.webp" alt="" width="35px">
                                Nombre
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4">
                            <div class="flex items-center flex-nowrap gap-3">
                                <img class="align-middle" src="assets/images/correo-electronico.webp" alt=""
                                     width="35px">
                                Correo electrónico
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4">
                            <div class="flex items-center flex-nowrap gap-3">
                                <img class="align-middle" src="assets/images/correo-electronico.webp" alt=""
                                     width="35px">
                                *Responsabilidad
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4">
                            <div class="flex items-center flex-nowrap gap-3">
                                <img class="align-middle" src="assets/images/acciones.webp" alt="" width="35px">
                                Acciones
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y-4 divide-white">
                    <!-- Itera sobre cada usuario y muestra una fila en la tabla -->
                    <tr class="divide-x-4 divide-white" v-for="user in $page.props.users" :key="user.id">
                        <td class="bg-gray-200 px-6 py-4 whitespace-nowrap">{{ user.id }}</td>
                        <td class="bg-gray-100 px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                        <td class="bg-gray-200 px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                        <td class="bg-gray-200 px-6 py-4 table-cell">
                        <span
                            v-for="adviserUser in user.get_adviser_office"
                            :key="adviserUser.get_estate.cod_dep"
                            class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full border border-blue-400 inline-block truncate">
                            {{ adviserUser.get_estate.cod_dep }} - {{ adviserUser.get_estate.dependence }}
                        </span>
                        </td>
                        <td class="bg-gray-100 px-6 py-4 whitespace-nowrap text-sm font-medium">

                            <button class="flex items-center text-indigo-600 hover:text-indigo-900">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path
                                        d="M17.414 2.586a2 2 0 00-2.828 0l-11 11A2 2 0 003 15v2a1 1 0 001 1h2a2 2 0 001.414-.586l11-11a2 2 0 000-2.828zM5 16H4v-1l9.293-9.293 1 1L5 16z"/>
                                </svg>
                                Editar
                            </button>
                            <button v-if="user.role_id == 3"
                                    class="flex items-center text-indigo-600 hover:text-indigo-900"
                                    @click="openAssocAdviser(user)">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M10 5a1 1 0 01.993.883L11 6v3h3a1 1 0 01.117 1.993L14 11h-3v3a1 1 0 01-1.993.117L9 14v-3H6a1 1 0 01-.117-1.993L6 9h3V6a1 1 0 01.883-.993L10 5z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Agregar Responsabilidad
                            </button>
                            <button class="flex items-center text-red-600 hover:text-red-900">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M8 4a1 1 0 00-.117 1.993L8 6h4a1 1 0 00.117-1.993L12 4H8zM5 7a1 1 0 011-.883L6 7v9a1 1 0 01-1.993.117L4 16V7zm8-1a1 1 0 01.117 1.993L13 7v9a1 1 0 01-1.993.117L11 16V7a1 1 0 011-1z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Eliminar
                            </button>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Modal :show="newUserModal" :closeable="true" @close="newUserModal = !newUserModal">
            <Register :role="$page.props.role" @close="close"></Register>
        </Modal>

        <Modal :show="assocAdviser" maxWidth="w-full" :closeable="true" @close="assocAdviser = !assocAdviser">
            <ListEstatesAssoc :user="userSelect" :estates="estates"></ListEstatesAssoc>
        </Modal>
    </AppLayout>
</template>
