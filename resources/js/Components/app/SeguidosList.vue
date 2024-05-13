<script setup>
import {ref} from 'vue';
import TextInput from '@/Components/TextInput.vue';
import SeguidosItem from '@/Components/app/SeguidosItem.vue';

const searchKeyword = ref('');

</script>

<template>
	<div class="px-3 py-4 bg-white shadow rounded-md max-h-[450px] overflow-hidden flex flex-col">
		<h2 class="text-2xl font-bold mb-4">Seguidores</h2>
		<TextInput :model-value="searchKeyword" placeholder="Buscar Seguidores..." class="w-full" />

		<div class="mt-3 flex-1 overflow-auto">
			<div v-if="false" class="text-gray-400 text-center p-3">
				Aún no tienes Amigos...
			</div>
			<div v-else>
				<SeguidosItem image="https://picsum.photos/50"
							name="Noah Gálvez" />
				<SeguidosItem image="https://picsum.photos/51"
							name="I Am Alberto" />
				<SeguidosItem image="https://picsum.photos/52"
							name="Salvador Camero" />
				<SeguidosItem image="https://picsum.photos/54"
							name="Sofía Carpintero" />
				<SeguidosItem image="https://picsum.photos/53"
							name="I Am Antonio" />
				<SeguidosItem image="https://picsum.photos/55"
							name="Francisco Luzón" />
			</div>
		</div>
	</div>

</template>