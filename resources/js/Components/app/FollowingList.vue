<script setup>
import {ref} from 'vue';
import TextInput from '@/Components/TextInput.vue';
import FollowingItem from '@/Components/app/FollowingItem.vue';

const searchKeyword = ref('');

</script>

<template>
	<div class="px-3">
		<h2 class="text-2xl font-bold mb-4">Seguidores</h2>
		<TextInput :model-value="searchKeyword" placeholder="Search followers..." />

		<div class="py-8">
			<div v-if="false" class="text-gray-400 flex text-center">
				Aún no tienes Amigos...
			</div>
			<div v-else>
				<FollowingItem image="https://picsum.photos/50"
							name="Noah Gálvez" />
			</div>
		</div>
	</div>

</template>