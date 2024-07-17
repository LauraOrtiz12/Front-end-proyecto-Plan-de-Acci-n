<script>
export default {
  data() {
    return {
      form: {
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
    };
  },
  methods: {
    guardarFormulario() {
      // Método para guardar el formulario, por ahora solo imprime en la consola
      console.log('Formulario guardado:', this.form);
    }
  }
};
</script>


<template>
    <!-- Contenedor principal del formulario -->
    <div class="max-w-4xl mx-auto mt-10">
      <!-- Sección del encabezado del formulario -->
      <div class="bg-white shadow-md rounded-lg p-6 mb-4">
        <!-- Encabezado del formulario con título y descripción -->
        <div class="border-b pb-4 mb-4">
          <h2 class="text-2xl font-bold mb-2">Proyectos</h2>
          <!-- Campo para la descripción del formulario -->
          <input v-model="form.descripcionFormulario" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Descripción del formulario">
        </div>
        <!-- Sección de las preguntas del formulario -->
        <div v-for="(pregunta, index) in form.preguntas" :key="index" class="bg-gray-100 p-4 mb-4 rounded-lg border">
          <!-- Campo para el título de la pregunta -->
          <div class="mb-4">
            <input v-model="pregunta.titulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Pregunta sin título">
          </div>
          <!-- Campo para la descripción de la pregunta (texto) -->
          <div v-if="pregunta.tipo === 'texto'" class="mb-4">
            <textarea v-model="pregunta.descripcion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Descripción"></textarea>
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
                <textarea v-model="pregunta.filas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="1. fila 1&#10;2. fila 2"></textarea>
              </div>
              <div class="w-1/2 ml-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Columnas</label>
                <textarea v-model="pregunta.columnas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Columna 1&#10;Agregar"></textarea>
              </div>
            </div>
          </div>
          <!-- Campo para cargar archivos -->
          <div v-if="pregunta.tipo === 'archivo'" class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Cargar archivos</label>
            <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
            <input v-model="pregunta.hora" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="time">
          </div>
          <!-- Campo para seleccionar fecha -->
          <div v-if="pregunta.tipo === 'fecha'" class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Fecha</label>
            <input v-model="pregunta.fecha" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="date">
          </div>
        </div>
        <!-- Botones para guardar y compartir el formulario -->
        <div class="flex justify-between">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" @click="guardarFormulario">
            Guardar formulario
          </button>
          <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Compartir formulario
          </button>
        </div>
      </div>
    </div>
  </template>



  <style scoped>
  /* Agrega aquí estilos personalizados si es necesario */
  </style>
