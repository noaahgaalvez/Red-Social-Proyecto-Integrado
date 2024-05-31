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
					class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
				  >
					<DialogTitle
					  as="h3"
					  class="flex justify-between items-center text-lg font-medium leading-6 text-gray-900"
					>
					  Actualizar Publicación
					  <button class="text-gray-400 hover:text-blue-500" @click="closeModal">
						<XMarkIcon class="w-6 h-6"/>
					  </button>
					</DialogTitle>
					<div class="flex items-center gap-2 mt-4 mb-6">
						<a href="javascript:void(0)">
							<img :src="publicacion.user.avatar_url !== '/storage/' ? publicacion.user.avatar_url : '/img/default_PerfilUsuario.jpg'" 
							class="w-[40px] rounded-full border-2 transition-all hover:border-blue-500" />
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
	  
					<div class="mt-4">
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

  const show = computed({
	get: () => props.modelValue,
	set: (value) => emit('update:modelValue', value)
  })

  const emit = defineEmits(['update:modelValue'])
  
  function closeModal() {
	show.value = false
  }

  function editarPublicacion() {
	const form = useForm({
		id: props.publicacion.id,
		body: props.publicacion.body
	})

	form.put(route('post.update', props.publicacion), {
		preserveScroll: true,
		onSuccess: () => {
			show.value = false
		}
	})
  }

</script>
  