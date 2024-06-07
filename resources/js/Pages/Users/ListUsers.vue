<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import Register from "@/Pages/Auth/Register.vue";
import EditUser from "@/Pages/Auth/EditUser.vue";
import { router } from '@inertiajs/vue3'
import ListEstatesAssoc from "@/Pages/Estate/ListEstatesAssoc.vue";

defineProps({
    role: Array,
    estates: Object
});


const pageTitle = "Lista de Usuarios";
const newUserModal = ref(false);
const editUserModal = ref(false);
const assocAdviser = ref(false);
const userSelect = ref(null);

const close = () => {
    newUserModal.value = false;
    router.reload({ only: ['users'] })

}

const closeEdit = () => {
    editUserModal.value = false;
    router.reload({ only: ['users'] })

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
    <AppLayout :title="pageTitle">

        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">{{ pageTitle }}</h1>
        </template>

        <div class="flex flex-col gap-4">
            <button @click="newUserModal = !newUserModal"
                class="transition-all w-fit ml-auto text-white px-4 py-2 bg-secondary-default rounded-md hover:bg-primary-default hover:scale-105">
                <i class="fa-solid fa-user-plus mr-1"></i>
                Nuevo Usuario
            </button>
            <div class="overflow-auto rounded-md shadow-md w-full" >
                <table class="w-full min-w-[1248px]">
                    <thead class="bg-secondary-default text-white">
                        <tr>
                            <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-hashtag"></i> Codigo</th>
                            <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-user"></i> Nombre</th>
                            <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-envelope"></i> Usuario o Correo</th>
                            <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-bars-progress"></i> Responsabilidad</th>
                            <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-user-tag"></i> Rol</th>
                            <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-hand"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-4 divide-white">
                        <tr class="divide-x-4 divide-white" v-for="user in $page.props.users" :key="user.id">
                            <td class="bg-gray-200 px-4 py-3">{{ user.code }}</td>
                            <td class="bg-gray-100 px-4 py-3">{{ user.name }}</td>
                            <td class="bg-gray-200 px-4 py-3">{{ user.email }}</td>
                            <td class="bg-gray-100 px-4 py-3">
                                <span v-for="adviserUser in user.get_adviser_office" :key="adviserUser.get_estate.cod_dep">
                                    {{ adviserUser.get_estate.cod_dep }} - {{ adviserUser.get_estate.dependence }}
                                </span>
                            </td>
                            <td class="bg-gray-200 px-4 py-3">{{ user.get_role.rol }} ({{ user.get_role.id }})</td>
                            <td class="flex flex-col px-4 py-3 text-sm font-medium gap-2">
    
                                <button
                                    class="transition-all text-primary-default border border-primary-default rounded-lg px-2 py-1 hover:text-white hover:bg-primary-default hover:scale-105"
                                    @click="openEditUser(user)">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </button>
                                <button v-if="user.role_id == 3"
                                    class="transition-all text-secondary-default border border-secondary-default rounded-lg px-2 py-1 hover:text-white hover:bg-secondary-default hover:scale-105 overflow-hidden"
                                    @click="openAssocAdviser(user)">
                                    <i class="fa-solid fa-plus"></i>
                                    Agregar Responsabilidad
                                </button>
                                <button
                                    class="transition-all text-red-500 border border-red-500 rounded-lg px-2 py-1 hover:text-white hover:bg-red-500 hover:scale-105">
                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- <div class="overflow-x-auto rounded-md shadow-md">
                <table class="overflow-hidden table-fixed">
                    <thead class="bg-secondary-default text-white uppercase text-xs tracking-wider ">
                        <tr>
                            <th scope="col" class="px-6 py-4">
                                <div class="flex items-center flex-nowrap gap-3 min-w-fit">
                                    <img class="align-middle" src="assets/images/ID.webp" alt="" width="35px">
                                    Código
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 min-w-fit">
                                <div class="flex items-center flex-nowrap gap-3">
                                    <img class="align-middle" src="assets/images/nombre.webp" alt="" width="35px">
                                    Nombre
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 min-w-fit">
                                <div class="flex items-center flex-nowrap gap-3">
                                    <img class="align-middle" src="assets/images/correo-electronico.webp" alt=""
                                        width="35px">
                                    Correo electrónico
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 min-w-fit">
                                <div class="flex items-center flex-nowrap gap-3">
                                    <img class="align-middle" src="assets/images/correo-electronico.webp" alt=""
                                        width="35px">
                                    *Responsabilidad
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 min-w-fit">
                                <div class="flex items-center flex-nowrap gap-3">
                                    <img class="align-middle" src="assets/images/correo-electronico.webp" alt=""
                                        width="35px">
                                    Rol
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 min-w-fit">
                                <div class="flex items-center flex-nowrap gap-3">
                                    <img class="align-middle" src="assets/images/acciones.webp" alt="" width="35px">
                                    Acciones
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-4 divide-white">
                        <tr class="divide-x-4 divide-white" v-for="user in $page.props.users" :key="user.id">
                            <td class="bg-gray-200 px-6 py-4 ">{{ user.code }}</td>
                            <td class="bg-gray-100 px-6 py-4 ">{{ user.name }}</td>
                            <td class="bg-gray-200 px-6 py-4 ">{{ user.email }}</td>
                            <td class="bg-gray-100 px-6 py-4 ">
                                <span v-for="adviserUser in user.get_adviser_office"
                                    :key="adviserUser.get_estate.cod_dep"
                                    class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 mb-2 px-2.5 py-0.5 border border-blue-400 inline-block">
                                    {{ adviserUser.get_estate.cod_dep }} - {{ adviserUser.get_estate.dependence }}
                                </span>
                            </td>
                            <td class="bg-gray-200 px-6 py-4  text-sm font-medium">
                                {{ user.get_role.rol }} ({{ user.get_role.id }})
                            </td>
                            <td class="flex flex-col bg-gray-100 px-5 py-4  text-sm font-medium gap-2">

                                <button
                                    class="transition-all text-primary-default border border-primary-default rounded-lg px-2 py-1 hover:text-white hover:bg-primary-default hover:scale-105"
                                    @click="openEditUser(user)">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </button>
                                <button v-if="user.role_id == 3"
                                    class="transition-all text-secondary-default border border-secondary-default rounded-lg px-2 py-1 hover:text-white hover:bg-secondary-default hover:scale-105 overflow-hidden"
                                    @click="openAssocAdviser(user)">
                                    <i class="fa-solid fa-plus"></i>
                                    Agregar Responsabilidad
                                </button>
                                <button
                                    class="transition-all text-red-500 border border-red-500 rounded-lg px-2 py-1 hover:text-white hover:bg-red-500 hover:scale-105">
                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
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
