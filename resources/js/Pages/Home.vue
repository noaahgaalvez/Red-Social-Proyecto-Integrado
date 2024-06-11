<script setup>
import { Head, Link } from '@inertiajs/vue3';
import SeguidosList from '@/Components/app/SeguidosList.vue';
import CreatePublicacion from '@/Components/app/CreatePublicacion.vue';
import PublicacionList from '@/Components/app/PublicacionList.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UsuariosList from '@/Components/app/UsuariosList.vue';

defineProps({
    posts: Object,
    users: Object,
});

</script>

<template>
    <Head title="StalkMe" />

    <AuthenticatedLayout>
        <div class="grid lg:grid-cols-12 gap-3 p-4 h-full">
            <div class="lg:col-span-3 lg:order-2 h-full overflow-hidden">
                <UsuariosList :usuarios="users.data" />
            </div>

            <div class="lg:col-span-9 lg:order-1 h-full overflow-hidden"> 
                <CreatePublicacion />
                <div class="p-4 bg-white shadow rounded-md flex gap-2 mb-3 text-center dark:bg-gray-700">
                    <a :href="route('dashboard')" class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative">
                        Todas las publicaciones
                    </a>
                    <a :href="route('seguidos')" class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Publicaciones de usuarios seguidos
                    </a>
                </div>
                <PublicacionList :posts="posts.data" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>

</style>
