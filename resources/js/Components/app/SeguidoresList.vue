<script setup>
import {ref, computed} from 'vue';
import TextInput from '@/Components/TextInput.vue';
import SeguidosItem from '@/Components/app/SeguidosItem.vue';

const search = ref('');

const searchUsers = computed(() => {
	return props.usuarios.filter(usuario => {
		return usuario.name.toLowerCase().includes(search.value.toLowerCase());
	});
});

const props = defineProps({
	usuarios: Array,
});

</script>

<template>
	<div class="px-3 py-4 bg-white shadow rounded-md max-h-[450px] overflow-hidden flex flex-col dark:bg-gray-700 dark:text-gray-200">
		<h2 class="text-2xl font-bold mb-4">Seguidores</h2>
		<TextInput v-model="search" placeholder="Buscar Usuarios..." class="w-full" />

		<div class="mt-3 flex-1 overflow-auto">
			<div v-if="usuarios.length === 0"
				class="text-gray-400 text-center p-3">
				Aún no te sigue nadie
			</div>
			<div v-else>
				<SeguidosItem v-for="usuario in searchUsers" :key="usuario.id" :usuario="usuario" class="mb-3" />
			</div>
		</div>
	</div>

</template>