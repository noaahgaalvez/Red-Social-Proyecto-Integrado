<script setup>
import { Head, Link } from '@inertiajs/vue3';
import SeguidosList from '@/Components/app/SeguidosList.vue';
import CreatePublicacion from '@/Components/app/CreatePublicacion.vue';
import PublicacionList from '@/Components/app/PublicacionList.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="StalkMe" />

    <AuthenticatedLayout>
    <div class="grid lg:grid-cols-12 gap-3 p-4 h-full">
        <div class="lg:col-span-3 lg:order-2 h-full overflow-hidden">
            <SeguidosList />
        </div>

        <div class="lg:col-span-9 lg:order-1 h-full overflow-hidden"> 
            <CreatePublicacion />
            <PublicacionList />
        </div>
    </div>
    </AuthenticatedLayout>
</template>

<style>

</style>
