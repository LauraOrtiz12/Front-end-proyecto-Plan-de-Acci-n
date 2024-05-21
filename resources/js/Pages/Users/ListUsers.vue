<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { router } from '@inertiajs/vue3'

// Define the 'role' prop as an array
defineProps({
    role: Array
});

// Create a reactive reference 'newUserModal' with an initial value of false
const newUserModal = ref(false);

// Define the 'close' function to set 'newUserModal' to false and reload the 'users' resource
const close = () => {
    newUserModal.value = false;
    router.reload({ only: ['users'] })
}
</script>

<template>
    <AppLayout>
        <!-- Header section -->
        <!-- <template #header>
      Lista de Usuarios
    </template> -->

        <div class="max-w-7xl m-auto px-3">
            <div class="py-6">
                <!-- Button to open the modal dialog -->
                <button @click="newUserModal = !newUserModal"
                    class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary-default focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
                                    <img class="align-middle" src="assets/images/acciones.webp" alt="" width="35px">
                                    Acciones
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-4 divide-white">
                        <!-- Iterate over each user and display a table row -->
                        <tr class="divide-x-4 divide-white" v-for="user in $page.props.users" :key="user.id">
                            <td class="bg-gray-200 px-6 py-4 whitespace-nowrap">{{ user.id }}</td>
                            <td class="bg-gray-100 px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                            <td class="bg-gray-200 px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                            <td class="bg-gray-100 px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Add action buttons here, e.g. edit or delete user -->
                                <div class="flex gap-3">
                                    <button
                                        class="hover:shadow-md transition border border-quaternary text-quaternary hover:text-white hover:bg-quaternary h-full w-full px-3 py-2 rounded-xl"><i
                                            class="fa-solid fa-pen-to-square"></i> Editar</button>
                                    <button
                                        class="hover:shadow-md transition border border-red-500 text-red-500 hover:bg-red-500 hover:text-white h-full w-full px-3 py-2 rounded-xl"><i
                                            class="fa-solid fa-trash"></i> Borrar</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal dialog to display the registration form -->
            <Modal v-if="newUserModal" :closeable="true" @close="newUserModal = !newUserModal">
                <Register :role="$page.props.role" @close="close"></Register>
            </Modal>
        </div>
    </AppLayout>
</template>