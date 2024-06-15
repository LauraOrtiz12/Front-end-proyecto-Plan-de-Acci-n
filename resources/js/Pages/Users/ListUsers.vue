<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import Register from "@/Pages/Auth/Register.vue";
import EditUser from "@/Pages/Auth/EditUser.vue";
import { router } from '@inertiajs/vue3'
import ListEstatesAssoc from "@/Pages/Estate/ListEstatesAssoc.vue";
import Swal from "sweetalert2";
import Load from "@/Components/Load.vue";
import Buttons from "@/Components/buttons.vue";
import Card from "@/Components/card.vue";


defineProps({
    role: Array,
    estates: Object
});

const pageTitle = "Lista de Usuarios";
const newUserModal = ref(false);
const editUserModal = ref(false);
const assocAdviser = ref(false);
const userSelect = ref(null);
const openModalImport = ref(false);
const fileImport = ref(null);
const load = ref(false);
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

const changeStatus = (id, status) => {
    axios.post('updateStatus', {
        id: id,
        status: status
    }).then(response => {
        if (response.status === 201)
            window.location.reload();
    });
}

const removeAdviser = (id) => {
    Swal.fire({
        target: "#card-assoc",
        title: "Aviso Importante?",
        text: "Está usted Seguro!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete('deleteAdvisorOffices', {
                params: {
                    id: id
                }
            })
                .then(response => {
                    window.location.reload();
                });
        }
    });
}

const loadFile = (event) => {
    fileImport.value = event.target.files[0];
}

const importFile = () => {
    load.value = true;
    const formData = new FormData();
    formData.append('file', fileImport.value);
    axios.post('importExcelUsers', formData).then((response) => {
        openModalImport.value = !openModalImport.value;
        window.location.reload();
        load.value = false;
        if (response.status == 200) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Error al Cargar el Archivo",
            });
        }
        if (response.status == 201) {
            Swal.fire({
                icon: "success",
                title: "Excelente",
                text: "Archivo Cargado",
            });
        }
    })

}

</script>
<template>
    <AppLayout :title="pageTitle">

        <template #header>
            <h1 class="font-semibold text-xl text-secondary-default my-auto">{{ pageTitle }}</h1>
        </template>

        <div class="flex flex-col gap-4 flex-1">
            <div class="flex gap-4 items-center justify-end">
                <Buttons @click="newUserModal = !newUserModal" icon="fa-solid fa-user-plus">
                    Nuevo Usuario
                </Buttons>
                <Buttons @click="openModalImport = !openModalImport" icon="fa-solid fa-file-import" variant="secondary">
                    Importar Usuarios
                </Buttons>
            </div>
            <Card class="w-full flex-1 overflow-x-auto overflow-y-auto">
                <div class="h-0">
                    <table class="w-full min-w-[1231px]">
                        <thead class="bg-secondary-default text-white sticky top-0">
                            <tr>
                                <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-hashtag"></i> Codigo
                                </th>
                                <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-user"></i> Nombre</th>
                                <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-envelope"></i> Usuario
                                    o
                                    Correo
                                </th>
                                <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-bars-progress"></i>
                                    Responsabilidad
                                </th>
                                <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-user-tag"></i> Rol
                                </th>
                                <th class="text-left px-4 py-3 text-nowrap"><i class="fa-solid fa-hand"></i> Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-4 divide-white">
                            <tr class="divide-x-4 divide-white" v-for="user in $page.props.users" :key="user.id">
                                <td class="bg-gray-200 px-4 py-3">{{ user.code }}</td>
                                <td class="bg-gray-100 px-4 py-3">{{ user.name }}</td>
                                <td class="bg-gray-200 px-4 py-3">{{ user.email }}</td>
                                <td class="bg-gray-100 px-4 py-3">
                                    <div>
                                        <span v-for="adviserUser in user.get_adviser_office"
                                            :key="adviserUser.get_estate.cod_dep"
                                            class="relative inline-block p-2 m-2 border rounded">
                                            {{ adviserUser.get_estate.cod_dep }} - {{ adviserUser.get_estate.dependence
                                            }}
                                            <button @click="removeAdviser(adviserUser)"
                                                class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center">
                                                &times;
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td class="bg-gray-200 px-4 py-3">{{ user.get_role.rol }} ({{ user.get_role.id }})</td>
                                <td class="bg-gray-100 flex flex-col px-4 py-3 text-sm font-medium gap-2">

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
                                    <button v-if="user.status == 'Activo'" @click="changeStatus(user.id, 'Inactivo')"
                                        class="transition-all text-red-500 border border-red-500 rounded-lg px-2 py-1 hover:text-white hover:bg-red-500 hover:scale-105">
                                        <i class="fa-solid fa-trash"></i>
                                        Inactivar
                                    </button>
                                    <button v-else @click="changeStatus(user.id, 'Activo')"
                                        class="transition-all text-green-500 border border-green-500 rounded-lg px-2 py-1 hover:text-white hover:bg-red-500 hover:scale-105">
                                        <i class="fa-solid fa-user"></i>
                                        Activar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Card>
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


        <Modal :show="openModalImport" class="py-8" :closeable="true">
            <div class="modal-container max-w-md mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg">
                <div class="modal-header mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Carga de Usuarios</h1>
                </div>
                <div class="modal-body mb-6">
                    <input type="file" @change="loadFile"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors duration-300"
                        accept="">
                </div>
                <div class="modal-footer flex justify-end mb-6" v-if="!load">
                    <button v-if="fileImport" @click="importFile"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-300">
                        Cargar
                    </button>
                </div>
                <Load v-else></Load>
                <div class="modal-actions flex justify-between items-center">
                    <a href="/format/ImportUsuarios.xlsx"
                        class="text-blue-600 hover:underline hover:text-blue-800 transition-colors duration-300">
                        Descargar Plantilla XLSX
                    </a>
                    <div class="w-100">
                        1,admin,Administrador
                        2,Direccion,Director(a) del área de planeación
                        3,Asesor,Asesor de planeacion
                        4,Director(a),Director(a) regional
                        5,Subdirector(a),Subdirector(a) de centro
                    </div>
                    <button @click="openModalImport = !openModalImport"
                        class="text-red-600 hover:underline hover:text-red-800 transition-colors duration-300">
                        Cerrar
                    </button>
                </div>
            </div>

        </Modal>
    </AppLayout>
</template>
