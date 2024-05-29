<script setup>
import { ref } from 'vue';
import TextInput from '../TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const crearPublicacion = ref(false);

const nuevaPublicacionForm = useForm({
    body: '',
});

function submit() {
    nuevaPublicacionForm.post(route('post.create'), {
        onSuccess: () => {
            nuevaPublicacionForm.reset();
            crearPublicacion.value = false;
        },
    });
}

</script>

<template>
    <div class="p-4 bg-white shadow rounded-md mb-3">
        <textarea @click="crearPublicacion = true" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            placeholder="Pulsa aquí para crear una publicación" v-model="nuevaPublicacionForm.body">
        </textarea>
        <div v-if="crearPublicacion" class="flex gap-2 justify-between">
            <button type="button" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative">
                Subir archivo
                <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0">
            </button>
            <button @click="submit" type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Crear Publicación
            </button>
        </div>
    </div>
</template>