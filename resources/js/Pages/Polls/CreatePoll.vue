<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const pageTitle = 'Encuestas'

const form = {
    descripcionFormulario: '',  // Descripción general del formulario
    preguntas: [
        { tipo: 'texto', titulo: '', descripcion: '' },  // Pregunta de tipo texto
        { tipo: 'checkbox', titulo: '', descripcion: false },  // Pregunta de tipo checkbox
        { tipo: 'matriz', titulo: '', filas: '', columnas: '' },  // Pregunta de tipo matriz
        { tipo: 'archivo', titulo: '' },  // Pregunta de tipo archivo
        { tipo: 'opciones', titulo: '', opciones: ['Opción 1', 'Opción 2', 'Opción 3', 'Opción 4'] },  // Pregunta de tipo opciones
        { tipo: 'hora', titulo: '', hora: '' },  // Pregunta de tipo hora
        { tipo: 'fecha', titulo: '', fecha: '' }  // Pregunta de tipo fecha
    ]
}
const isOpen = ref(false);

function toggleAccordion() {
  isOpen.value = !isOpen.value;
}
function guardarFormulario() {
  console.log('Formulario guardado:', form.value);
}



</script>


<template>
    <AppLayout>
        <div class="">
            <div class="flex justify-end gap-4">
                <svg width="39" height="25" viewBox="0 0 39 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-20 h-auto rounded shadow-lg hover:filter hover:bg-secondary-default transition duration-300"
                    style="width: 50px; height: auto; border-radius: 8px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">
                    <path
                        d="M19.5384 24.05C12.6887 23.8617 7.11011 21.2478 2.32007 16.7905C1.71775 16.2312 1.20474 15.573 0.58722 15.0308C-0.148101 14.384 -0.047398 13.8513 0.615721 13.2387C1.19714 12.7023 1.68545 12.0649 2.27637 11.5418C2.82168 11.0586 2.77038 10.699 2.28397 10.2196C1.63035 9.57472 1.03943 8.86894 0.410515 8.1993C-0.00939693 7.75033 -0.189902 7.2443 0.271811 6.7706C0.796226 6.23032 1.30924 6.50427 1.74435 6.97035C2.43787 7.71038 3.13899 8.4447 3.81161 9.20185C4.17642 9.61277 4.47093 9.61087 4.94404 9.31029C6.40899 8.37432 7.91003 7.49351 9.41677 6.62412C9.86518 6.36539 10.002 6.11428 9.73598 5.64058C9.30087 4.86821 8.89806 4.07682 8.48194 3.29304C8.17224 2.709 7.84353 2.04887 8.60735 1.63605C9.42817 1.1928 9.79298 1.88527 10.116 2.48832C10.534 3.27211 10.952 4.05399 11.3472 4.84919C11.6151 5.38947 11.9552 5.52454 12.5709 5.37615C14.2296 4.98045 15.9055 4.64183 17.587 4.35457C18.1589 4.25755 18.3375 4.01594 18.328 3.48898C18.3128 2.69569 18.3147 1.90239 18.3337 1.111C18.3527 0.51745 18.5598 0 19.2457 0C19.9374 0 20.1236 0.534571 20.1407 1.12051C20.1635 1.9119 20.1597 2.7052 20.154 3.49849C20.1502 4.02736 20.363 4.25755 20.9235 4.35647C22.6031 4.65134 24.2752 5.00328 25.9377 5.38566C26.4907 5.51312 26.827 5.43703 27.0892 4.90055C27.5338 3.99121 28.0335 3.1066 28.5161 2.21628C28.7973 1.69693 29.1887 1.29743 29.8101 1.60942C30.4599 1.93473 30.4371 2.48072 30.1179 3.06475C29.677 3.87136 29.2761 4.6989 28.8201 5.496C28.5028 6.0515 28.5788 6.35778 29.1735 6.6869C30.6385 7.49731 32.0844 8.35339 33.481 9.27605C34.0472 9.65082 34.3626 9.5576 34.7597 9.11054C35.4114 8.37432 36.0859 7.65902 36.7623 6.94943C37.1652 6.5271 37.6364 6.23603 38.1646 6.72304C38.7175 7.23288 38.4914 7.74272 38.0582 8.21071C37.4768 8.8385 36.922 9.49482 36.3044 10.0846C35.7116 10.6496 35.5767 11.0776 36.3101 11.675C36.9923 12.2305 37.5319 12.9572 38.1589 13.585C38.5085 13.935 38.5902 14.228 38.2292 14.637C33.1959 20.3441 27.0075 23.7095 19.5384 24.05ZM19.1602 21.7177C23.31 21.7614 26.7605 18.3866 26.8004 14.2432C26.8422 10.0161 23.519 6.62983 19.2705 6.57275C15.191 6.51758 11.7044 9.91906 11.6702 13.9902C11.636 18.2325 14.9687 21.6739 19.1583 21.7196L19.1602 21.7177ZM12.3391 21.0594C12.4132 20.9567 12.4873 20.854 12.5614 20.7494C9.05006 16.3453 9.05576 11.9299 12.6241 7.43073C12.2992 7.45927 12.1357 7.43644 12.0008 7.48971C8.49904 8.85182 5.44186 10.8855 2.81978 13.585C2.36377 14.0549 2.45307 14.4144 2.89009 14.772C4.45383 16.0524 5.94727 17.443 7.61742 18.5654C9.08616 19.5528 10.7563 20.2376 12.3372 21.0575L12.3391 21.0594ZM25.8655 20.8331C26.0802 20.8578 26.1809 20.9015 26.255 20.873C29.9089 19.5261 33.0591 17.4164 35.761 14.6161C36.1638 14.1975 35.9852 13.9255 35.6565 13.5831C33.0933 10.9216 30.0894 8.9222 26.6617 7.56009C26.4641 7.4821 26.2303 7.49161 25.8446 7.43834C29.487 12.0003 29.3996 16.4119 25.8655 20.8331Z"
                        fill="#39A900" />
                </svg>


                <!-- Botones para guardar y compartir el formulario -->
                <div class="flex justify-end gap-4">
                    <button
                        class="bg-secondary-default hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        @click="guardarFormulario">
                        Guardar formulario
                    </button>
                    <button
                        class="bg-secondary-default hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Compartir formulario
                    </button>
                </div>
            </div>
            <br>



            <Card class="w-full flex-1 overflow-x-auto overflow-y-auto justify-between">
                <div class="border border-gray-300">
                    <table class="w-full min-w[12px]">
                        <thead class="bg-secondary-default border text-white sticky top-1">
                            <tr>
                                <th class="flex items-center  text-left p-2">
                                    <img src="/assets/images/Group 689.png" class="inline-block" alt="Icono" />
                                    <h1 class="rm-0">Formulario sin titulo</h1>
                                    <button @click="toggleAccordion" class="accordion-button  text-white cursor-pointer p-2 w-full text-left rounded transition duration-400"></button>
                                     <div v-show="isOpen" class="accordion-content">
                                        <p>Descripcion del Formulario</p>
                                        </div>

                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
             </Card>











            <!-- Sección del encabezado del formulario -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                <!-- Encabezado del formulario con título y descripción -->
                <div class="border-b pb-4 mb-4">
                    <h2 class="text-2xl font-bold mb-2">Proyectos</h2>
                    <!-- Campo para la descripción del formulario -->
                    <input v-model="form.descripcionFormulario"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="text" placeholder="Descripción del formulario">
                </div>
                <!-- Sección de las preguntas del formulario -->
                <div v-for="(pregunta, index) in form.preguntas" :key="index"
                    class="bg-gray-100 p-4 mb-4 rounded-lg border">
                    <!-- Campo para el título de la pregunta -->
                    <div class="mb-4">
                        <input v-model="pregunta.titulo"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="text" placeholder="Pregunta sin título">
                    </div>
                    <!-- Campo para la descripción de la pregunta (texto) -->
                    <div v-if="pregunta.tipo === 'texto'" class="mb-4">
                        <textarea v-model="pregunta.descripcion"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Descripción"></textarea>
                    </div>
                    <!-- Campo para la descripción de la pregunta (checkbox) -->
                    <div v-if="pregunta.tipo === 'checkbox'" class="mb-4">
                        <input type="checkbox" v-model="pregunta.descripcion" class="mr-2 leading-tight">
                        <label class="text-gray-700">Descripción</label>
                    </div>
                    <!-- Campo para la matriz de preguntas -->
                    <div v-if="pregunta.tipo === 'matriz'" class="mb-4">
                        <div class="flex">
                            <div class="w-1/2 mr-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Filas</label>
                                <textarea v-model="pregunta.filas"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="1. fila 1&#10;2. fila 2"></textarea>
                            </div>
                            <div class="w-1/2 ml-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Columnas</label>
                                <textarea v-model="pregunta.columnas"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Columna 1&#10;Agregar"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Campo para cargar archivos -->
                    <div v-if="pregunta.tipo === 'archivo'" class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Cargar archivos</label>
                        <input type="file"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <!-- Campo para opciones de selección -->
                    <div v-if="pregunta.tipo === 'opciones'" class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Opciones</label>
                        <div v-for="(opcion, i) in pregunta.opciones" :key="i" class="flex items-center mb-2">
                            <input type="checkbox" class="mr-2 leading-tight">
                            <span>{{ opcion }}</span>
                        </div>
                    </div>
                    <!-- Campo para seleccionar hora -->
                    <div v-if="pregunta.tipo === 'hora'" class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Hora</label>
                        <input v-model="pregunta.hora"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="time">
                    </div>
                    <!-- Campo para seleccionar fecha -->
                    <div v-if="pregunta.tipo === 'fecha'" class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Fecha</label>
                        <input v-model="pregunta.fecha"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="date">
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

