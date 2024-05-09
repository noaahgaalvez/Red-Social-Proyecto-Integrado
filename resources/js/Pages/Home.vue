<script setup>
import FollowingList from '@/Components/app/FollowingList.vue';
import { Head, Link } from '@inertiajs/vue3';

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
    
    <div class="grid grid-cols-9 gap-3">
        <div class="col-span-6">
            
        </div>

        <div class="col-span-3 py-6">
            <FollowingList />
        </div>
    </div>
</template>

<style>

</style>
