<script setup>
import { ref } from 'vue';

const crearPublicacion = ref(false);
</script>

<template>
    <div class="p-4">
        <div @click="crearPublicacion = true" class="py-3 px-2 text-gray-500 text-sm text-center border border-gray-300 rounded-md mb-3 bg-indigo-600 text-white cursor-pointer">
            Pulsa aquí para crear una publicación
        </div>
        <div v-if="crearPublicacion" class="flex gap-2 justify-between">
            <button type="button" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative">
                Subir archivo
                <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0">
            </button>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Crear
            </button>
        </div>
    </div>
</template>