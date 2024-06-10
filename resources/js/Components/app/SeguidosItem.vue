<script setup>
defineProps({
	usuario: Object,
});

</script>

<template>
	<div class="flex items-center gap-2">
        <a :href="route('profile', usuario.username)">
            <img :src="usuario.avatar_url !== '/storage/' ? usuario.avatar_url : '/img/default_PerfilUsuario.jpg'"
            class="w-[40px] rounded-full border border-2 transition-all hover:border-blue-500 aspect-square object-cover" />
        </a>
        <div>
            <h4 class="font-bold">
                <a :href="route('profile', usuario.username)"
                class="hover:underline">
                    {{ usuario.name }}
                </a>
            </h4>
        </div>
    </div>
</template>