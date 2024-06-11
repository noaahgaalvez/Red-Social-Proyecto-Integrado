<template>
	<teleport to="body">
		<TransitionRoot appear :show="show" as="template">
		  <Dialog as="div" @close="closeModal" class="relative z-10">
			<TransitionChild
			  as="template"
			  enter="duration-300 ease-out"
			  enter-from="opacity-0"
			  enter-to="opacity-100"
			  leave="duration-200 ease-in"
			  leave-from="opacity-100"
			  leave-to="opacity-0"
			>
			  <div class="fixed inset-0 bg-black/25" />
			</TransitionChild>
	  
			<div class="fixed inset-0 overflow-y-auto">
			  <div
				class="flex min-h-full items-center justify-center p-4 text-center"
			  >
				<TransitionChild
				  as="template"
				  enter="duration-300 ease-out"
				  enter-from="opacity-0 scale-95"
				  enter-to="opacity-100 scale-100"
				  leave="duration-200 ease-in"
				  leave-from="opacity-100 scale-100"
				  leave-to="opacity-0 scale-95"
				>
				  <DialogPanel
					class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all dark:bg-gray-900 dark:text-gray-300"
				  >
					<DialogTitle
					  as="h3"
					  class="flex justify-between items-center text-lg font-medium leading-6 text-gray-900 dark:text-gray-300"
					>
					  Actualizar Publicación
					  <button class="text-gray-400 hover:text-blue-500" @click="closeModal">
						<XMarkIcon class="w-6 h-6"/>
					  </button>
					</DialogTitle>
					<div class="flex items-center gap-2 mt-4 mb-6">
						<a href="javascript:void(0)">
							<img :src="publicacion.user.avatar_url !== '/storage/' ? publicacion.user.avatar_url : '/img/default_PerfilUsuario.jpg'" 
							class="w-[40px] rounded-full border-2 transition-all hover:border-blue-500 aspect-square object-cover" />
						</a>
						<div>
							<h4 class="font-bold">
								<a href="javascript:void(0)" class="hover:underline">
									{{ publicacion.user.name }}
								</a>
							</h4>
						</div>
					</div>
					<div class="mt-2">
					  <p class="text-sm text-gray-500">
						<textarea class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
							v-model="publicacion.body">
						</textarea>
					  </p>
					</div>
					<div class="grid grid-cols-2 gap-3">
						<template v-for="attachment in publicacion.attachments">
							<div class="group bg-gray-200 aspect-square flex items-center justify-center text-gray-600 relative">
								<div v-if="attachment.deleted" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-white">
									Este archivo se borrará
								</div>

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

									<span>{{ attachment.name }}</span>
								</template>
							</div>
						</template>
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
	  
					<div class="mt-4 flex gap-2 justify-between">
						<button type="button" class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative">
							Subir archivo
							<input @click.stop @change="subirArchivo" type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0">
						</button>
					  <button
						type="button"
						class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative"
						@click="editarPublicacion"
					  >
						Editar Contenido
					  </button>
					</div>
				  </DialogPanel>
				</TransitionChild>
			  </div>
			</div>
		  </Dialog>
		</TransitionRoot>
	</teleport>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import {
	TransitionRoot,
	TransitionChild,
	Dialog,
	DialogPanel,
	DialogTitle,
  } from '@headlessui/vue'
  import { computed } from 'vue';
  import {XMarkIcon} from '@heroicons/vue/20/solid'
  import { useForm } from '@inertiajs/vue3';

  const props = defineProps({
	publicacion: {
		type: Object,
		required: true
	},
	modelValue: Boolean
  })

  const archivosAdjuntos = ref([])

  const show = computed({
	get: () => props.modelValue,
	set: (value) => emit('update:modelValue', value)
  })

  const emit = defineEmits(['update:modelValue'])

  const form = useForm({
		id: null,
		body: '',
		attachments: [],
		deleteAttachments: [],
		_method: 'POST'
	})
  
  function editarPublicacion() {
	form.id = props.publicacion.id
	form.body = props.publicacion.body
	form.attachments = archivosAdjuntos.value.map(myFile => myFile.file)

	form._method = 'PUT'
	form.post(route('post.update', props.publicacion), {
		preserveScroll: true,
		onSuccess: () => {
			closeModal()
		}
	})
  }

  function closeModal() {
	show.value = false
	archivosAdjuntos.value = []
	form.deleteAttachments = []
	props.publicacion.attachments.forEach((attachment) => attachment.deleted = false)
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
	if (attachment.file) {
		archivosAdjuntos.value = archivosAdjuntos.value.filter((file) => file !== attachment)
	} else {
		form.deleteAttachments.push(attachment.id)
		attachment.deleted = true
	}
  }
</script>