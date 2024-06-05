<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import Register from "@/Pages/Auth/Register.vue";
import EditUser from "@/Pages/Auth/EditUser.vue";
import {router} from '@inertiajs/vue3'
import ListEstatesAssoc from "@/Pages/Estate/ListEstatesAssoc.vue";

defineProps({
    role: Array,
    estates: Object
});

const newUserModal = ref(false);
const editUserModal = ref(false);
const assocAdviser = ref(false);
const userSelect = ref(null);

const close = () => {
    newUserModal.value = false;
    router.reload({only: ['users']})

}

const closeEdit = () => {
    editUserModal.value = false;
    router.reload({only: ['users']})

}
const openAssocAdviser = (user) => {
    userSelect.value = user;
    assocAdviser.value = !assocAdviser.value;
}

const closeAssoc = () => {
    assocAdviser.value = !assocAdviser.value;
    window.location.reload();
}

const openEditUser = (user) => {
    userSelect.value = user;
    editUserModal.value = !editUserModal.value;
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
                                Código
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
                                <img class="align-middle" src="assets/images/correo-electronico.webp" alt=""
                                     width="35px">
                                Rol
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
                        <td class="bg-gray-200 px-6 py-4 whitespace-nowrap">{{ user.code }}</td>
                        <td class="bg-gray-100 px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                        <td class="bg-gray-200 px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                        <td class="bg-gray-200 px-6 py-4 table-cell">
                         <span v-for="adviserUser in user.get_adviser_office" :key="adviserUser.get_estate.cod_dep" class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 mb-2 px-2.5 py-0.5 border border-blue-400 inline-block">
          {{ adviserUser.get_estate.cod_dep }} - {{ adviserUser.get_estate.dependence }}
        </span>
                        </td>
                        <td class="bg-gray-100 px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{ user.get_role.rol }} ({{ user.get_role.id }})
                        </td>
                        <td class="flex flex-col bg-gray-100 px-5 py-4 whitespace-nowrap text-sm font-medium gap-2">

                            <button class="border border-primary-default w-full py-1 rounded-lg flex items-center justify-center text-black hover:bg-primary-default transition-all gap-1 hover:text-white " @click="openEditUser(user)">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Editar
                            </button>
                            <button v-if="user.role_id == 3"
                                    class="border border-secondary-default w-full py-1 rounded-lg justify-center flex items-center text-balack hover:bg-secondary-default hover:text-white"
                                    @click="openAssocAdviser(user)">
                                    <i class="fa-solid fa-plus"></i>
                                Agregar Responsabilidad
                            </button>
                            <button class="w-full py-1 rounded-lg flex border border-red-500 items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-all  gap-1">
                                <i class="fa-solid fa-trash"></i>
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

        <Modal :show="editUserModal" :closeable="true" @close="editUserModal = !editUserModal">
            <EditUser :user="userSelect" :role="$page.props.role" @close="closeEdit"></EditUser>
        </Modal>

        <Modal :show="assocAdviser" :closeable="true" @close="assocAdviser = !assocAdviser">
            <ListEstatesAssoc :user="userSelect" :estates="estates" @close="closeAssoc"></ListEstatesAssoc>
        </Modal>
    </AppLayout>
</template>
