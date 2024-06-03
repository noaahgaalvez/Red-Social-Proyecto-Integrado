<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import {XMarkIcon} from '@heroicons/vue/20/solid'

const crearPublicacion = ref(false);

const nuevaPublicacionForm = useForm({
    id: null,
    body: '',
    attachments: [],
});

const archivosAdjuntos = ref([]);

function submit() {
    nuevaPublicacionForm.attachments = archivosAdjuntos.value.map(myFile => myFile.file)
    nuevaPublicacionForm.post(route('post.create'), {
		preserveScroll: true,
        onSuccess: () => {
            resetForm();
        },
    });
}

function resetForm() {
	nuevaPublicacionForm.reset();
	archivosAdjuntos.value = [];
	crearPublicacion.value = false;
}

function esImagen(attachment) {
        let type = attachment.type || attachment.image || attachment.url;
        return type.includes('image');
    }

  async function subirArchivo($event) {
	for (const file of $event.target.files) {
		const myFile = {
			file,
			url: await readFile(file)
		}
		
		archivosAdjuntos.value.push(myFile)
	}
    $event.target.value = null
  }

  async function readFile(file) {
	return new Promise((resolve, reject) => {
		if (esImagen(file)) {
			const reader = new FileReader()
			reader.onload = () => {
				resolve(reader.result)
			}
			reader.onerror = reject

			reader.readAsDataURL(file)
		} else {
            resolve(file.name)
		}
	})
  }

  function deleteAttachment(attachment) {
	archivosAdjuntos.value = archivosAdjuntos.value.filter((file) => file !== attachment)
  }

</script>

<template>
    <div class="p-4 bg-white shadow rounded-md flex flex-col gap-2 mb-3">
        <textarea @click="crearPublicacion = true" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            placeholder="Pulsa aquí para crear una publicación" v-model="nuevaPublicacionForm.body">
        </textarea>
        <div class="grid grid-cols-2 gap-3">
						<template v-for="attachment in archivosAdjuntos">
						
							<div class="group bg-gray-200 aspect-square flex items-center justify-center text-gray-600 relative">
                                <button
									@click="deleteAttachment(attachment)"
									class="absolute right-1 top-1 p-1 bg-white bg-opacity-50 rounded-full hover:bg-opacity-100">
									<XMarkIcon class="w-5 h-5" />
								</button>

								<img v-if="esImagen(attachment)"
								:src="attachment.url" class="object-cover aspect-square" />
								<template v-else>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-15 h-16">
										<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
									</svg>

									<span>{{ attachment.file.name }}</span>
								</template>
							</div>
            			</template>
        			</div>
        
        <div v-if="crearPublicacion" class="flex gap-2 justify-between">
            <button type="button" class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative">
				Subir archivo
				<input @click.stop @change="subirArchivo" type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0">
			</button>
            <button @click="submit" type="submit" class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Crear Publicación
            </button>
        </div>
    </div>
</template>