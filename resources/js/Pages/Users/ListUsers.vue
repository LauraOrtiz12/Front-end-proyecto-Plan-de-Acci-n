<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import Register from "@/Pages/Auth/Register.vue";



defineProps({
    role: Array
});

const newUserModal = ref(false);


</script>
<template>
    <AppLayout>
        <!-- <template #header>
            Lista de Usuarios
        </template> -->
        <div class="max-w-7xl m-auto px-3">
            <div class="py-6">
                <button @click="newUserModal = !newUserModal"
                    class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-user-plus mr-1"></i>
                    Nuevo Usuario
                </button>
            </div>
            <div class="overflow-x-auto rounded-xl shadow-md">
                <table class="w-full min-w-[970px] overflow-hidden table-fixed">
                    <thead class="bg-secondary text-white uppercase text-xs tracking-wider whitespace-nowrap">
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
                        <!-- Itera sobre cada usuario y muestra una fila en la tabla -->
                        <tr class="divide-x-4 divide-white" v-for="user in $page.props.users" :key="user.id">
                            <td class="bg-gray-200 px-6 py-4 whitespace-nowrap">{{ user.id }}</td>
                            <td class="bg-gray-100 px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                            <td class="bg-gray-200 px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                            <td class="bg-gray-100 px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <!-- Agrega botones de acciones aquí, por ejemplo, un botón para editar o eliminar el usuario -->
                                <button class="text-indigo-600 hover:text-indigo-900">Editar</button>
                                <button class="text-red-600 hover:text-red-900">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Modal :show="newUserModal" :closeable="true" @close="newUserModal = !newUserModal">
            <Register :role="$page.props.role" @close="newUserModal = !newUserModal"></Register>
        </Modal>
    </AppLayout>
</template>
