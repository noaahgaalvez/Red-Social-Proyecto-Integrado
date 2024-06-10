<script setup>
import PublicacionItem from '@/Components/app/PublicacionItem.vue';

defineProps({
	posts: Array,
});

</script>

<template>
	<div class="overflow-auto">
		<PublicacionItem v-for="post of posts" :key="post.id" :publicacion="post" />
	</div>
</template>