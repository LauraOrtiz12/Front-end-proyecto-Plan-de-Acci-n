<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import Register from "@/Pages/Auth/Register.vue";



defineProps({
    role : Array
});

const newUserModal = ref(false);


</script>
<template>
    <AppLayout>
        <!-- <template #header>
            Lista de Usuarios
        </template> -->
        <div>
            <div class="p-4 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div  class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                   <div class="py-6 px-2">
                       <button @click="newUserModal = !newUserModal" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                           Nuevo Usuario
                       </button>
                   </div>

                    <div class="overflow-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead  class="bg-secondary">
                            <tr>
                                
                                <th scope="col" class="text-center text-white px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><img src="assets/images/ID.webp" alt="" width="35px">ID</th>
                                <th scope="col" class="text-center text-white px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><img src="assets/images/nombre.webp" alt="" width="35px">Nombre</th>
                                <th scope="col" class="text-center text-white px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><img src="assets/images/correo-electronico.webp" alt="" width="35px">Correo electrónico</th>
                                <th scope="col" class="text-center text-white px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><img src="assets/images/acciones.webp" alt="" width="35px">Acciones</th>
                                
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Itera sobre cada usuario y muestra una fila en la tabla -->
                            <tr v-for="user in $page.props.users" :key="user.id">
                                <td class="bg-gray-300 px-6 py-4 whitespace-nowrap">{{ user.id }}</td>
                                <td class="bg-gray-200 px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                                <td class="bg-gray-300 px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                                <td class="bg-gray-200 px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <!-- Agrega botones de acciones aquí, por ejemplo, un botón para editar o eliminar el usuario -->
                                    <button class="text-indigo-600 hover:text-indigo-900">Editar</button>
                                    <button class="text-red-600 hover:text-red-900">Eliminar</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <Modal :show="newUserModal" :closeable="true" @close="newUserModal = !newUserModal">
            <Register :role="$page.props.role" @close="newUserModal = !newUserModal"></Register>
        </Modal>
    </AppLayout>
</template>
