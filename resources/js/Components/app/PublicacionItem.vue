<script setup>
    import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
    import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
    import { ChevronDownIcon } from '@heroicons/vue/20/solid';
    import PublicacionDialog from './PublicacionDialog.vue';
    import { ref } from 'vue';
    import { router, usePage } from '@inertiajs/vue3';
    import axiosClient from '@/axiosClient.js';

    const showDialog = ref(false);

    const authUser = usePage().props.auth.user;

    const props = defineProps({
        publicacion: Object
    });

    const nuevoComentario = ref('');

    function esImagen(attachment) {
        let type = attachment.type || attachment.image || attachment.url;
        return type.includes('image');
    }

    function deletePublicacion() {
        if (window.confirm('¿Estás seguro de eliminar esta publicación?')) {
           router.delete(route('post.destroy', props.publicacion), {
                preserveScroll: true,
            });
        }
    }

    function deleteComment(comment) {
        if (window.confirm('¿Estás seguro de eliminar este comentario?')) {
            axiosClient.delete(route('comment.delete', comment.id))
            .then(() => {
                props.publicacion.comments = props.publicacion.comments.filter(c => c.id !== comment.id);
                props.publicacion.num_comments--;
            });
        }
    }

    function enviarInteraccion(tipo) {
        axiosClient.post(route('post.reaction', props.publicacion), {
            type: tipo
        })
        .then(({ data }) => {
            props.publicacion.user_reaction = data.user_reaction;
            props.publicacion.reactions = data.reactions;
        })
    }

    function enviarComentario() {
        axiosClient.post(route('post.comment', props.publicacion), {
            comment: nuevoComentario.value
        })
        .then(({ data }) => {
            nuevoComentario.value = '';
            props.publicacion.comments.push(data);
            props.publicacion.num_comments++;
        })
    }

</script>

<template>
    <!-- Publicación -->
    <div class="flex flex-col gap-4 p-4 bg-white shadow rounded-md mb-3 dark:bg-gray-700 dark:text-gray-300">
        <!-- Usuario -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <a :href="route('profile', publicacion.user.username)">
                    <img :src="publicacion.user.avatar_url !== '/storage/' ? publicacion.user.avatar_url : '/img/default_PerfilUsuario.jpg'"
                    class="w-[40px] rounded-full border border-2 transition-all hover:border-blue-500 aspect-square object-cover" />
                </a>
                <div>
                    <h4 class="font-bold">
                        <a :href="route('profile', publicacion.user.username)"
                        class="hover:underline">
                            {{ publicacion.user.name }}
                        </a>
                    </h4>
                </div>
            </div>
            <div>
                <Menu as="div" class="relative z-10">
                    <MenuButton as="button" class="text-gray-400 hover:text-blue-500">
                        <ChevronDownIcon class="w-6 h-6" />
                    </MenuButton>

                    <MenuItems as="div" class="absolute right-0 w-40 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:divide-gray-700 dark:ring-gray-700">
                        <MenuItem as="button" class="w-full flex items-center gap-4 p-2 hover:bg-indigo-600 hover:text-white cursor-pointer"
                            @click="showDialog = true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                            <span>Editar</span>
                        </MenuItem>
                        <MenuItem as="button" class="w-full flex items-center gap-4 p-2 hover:bg-indigo-600 hover:text-white cursor-pointer"
                            @click="deletePublicacion">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            <span>Borrar</span>
                        </MenuItem>
                    </MenuItems>
                </Menu>
            </div>
        </div>
        <!-- Contenido -->
        <div>
            <Disclosure v-slot="{ open }" v-if="publicacion.body">
                <div v-if="!open" v-html="publicacion.body.substring(0, 200)" />
                <template v-if="publicacion.body.length > 200">
                    <DisclosurePanel>
                        <div v-html="publicacion.body" />
                    </DisclosurePanel>
                    <div class="flex justify-end">
                        <DisclosureButton class="text-gray-400 hover:text-blue-500 cursor-pointer">
                            {{ open ? 'Ocultar' : 'Leer más' }}
                        </DisclosureButton>
                    </div>
                </template>
            </Disclosure>
        </div>
        <!-- Archivos Adjuntos -->
        <div class="grid grid-cols-3 gap-3">
            <template v-for="attachment in publicacion.attachments">
               
                <div class="group bg-gray-200 aspect-square flex items-center justify-center text-gray-600 relative">
                    <img v-if="esImagen(attachment)" :src="attachment.url" class="object-cover aspect-square" />
                    <template v-else>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-15 h-16">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>

                        <span>{{ attachment.name }}</span>
                    </template>
                </div>
            </template>
        </div>
        <div class="text-gray-400 text-right text-sm">
            {{ publicacion.created_at }}
        </div> 
        <!-- Acciones -->
        <Disclosure v-slot="{ open }">
            <div class="flex gap-10 justify-center w-full">
                <button 
                    @click="enviarInteraccion('like')"
                    class="flex gap-2 items-center text-gray-600 hover:text-blue-500 hover:bg-gray-100 p-2 rounded-md cursor-pointer dark:text-gray-300 dark:hover:text-blue-500"
                    :class="[publicacion.user_reaction ? 'text-blue-500' : '']"
                >
                    <svg v-if="publicacion.user_reaction" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                    </svg>

                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                    </svg>

                    <span class="text-sm mr-2">
                        {{ publicacion.reactions }}
                    </span>

                    Me gusta!
                </button>
            
                <DisclosureButton
                    class="flex gap-2 items-center text-gray-600 hover:text-blue-500 hover:bg-gray-100 p-2 rounded-md cursor-pointer dark:text-gray-300 dark:hover:text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                    </svg>

                    <span class="text-sm mr-2">
                        {{ publicacion.num_comments }}
                    </span>

                    Comentar
                </DisclosureButton>
            </div>
            <DisclosurePanel class="mt-4">
                <div>
                    <div class="flex items-center gap-2 w-full mb-4">
                        <a href="javascript:void(0)">
                            <img :src="authUser.avatar_url !== '/storage/' ? authUser.avatar_url : '/img/default_PerfilUsuario.jpg'"
                            class="w-[40px] rounded-full border border-2 transition-all aspect-square object-cover" />
                        </a>
                        <div class="w-full flex gap-2">
                            <textarea v-model="nuevoComentario" class="w-full p-2 border border-gray-300 rounded-md dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                placeholder="Escribe un comentario..."></textarea>
                            <button @click="enviarComentario" type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Enviar Comentario
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <div v-for="comment in publicacion.comments" :key="comment.id" class="flex items-start gap-2 mb-4">
                        <a :href="route('profile', comment.user.username)">
                            <img :src="comment.user.avatar_url !== '/storage/' ? comment.user.avatar_url : '/img/default_PerfilUsuario.jpg'"
                            class="w-[40px] rounded-full border border-2 transition-all hover:border-blue-500 aspect-square object-cover" />
                        </a>
                        <div class="w-full">
                            <div class="flex items
                            -center justify-between">
                                <div>
                                    <h4 class="font-bold">
                                        <a :href="route('profile', comment.user.username)"
                                        class="hover:underline">
                                            {{ comment.user.name }}
                                        </a>
                                    </h4>
                                </div>
                                <div class="text-gray-400 text-sm flex gap-2 items-center">
                                    {{ comment.updated_at }}
                                    <Menu as="div" class="relative z-10">
                                        <MenuButton as="button" class="text-gray-400 hover:text-blue-500">
                                            <ChevronDownIcon class="w-6 h-6" />
                                        </MenuButton>

                                        <MenuItems as="div" class="absolute right-0 w-40 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:divide-gray-700 dark:ring-gray-700">
                                            <MenuItem as="button" class="w-full flex items-center gap-4 p-2 hover:bg-indigo-600 hover:text-white cursor-pointer"
                                                @click="deleteComment(comment)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                <span>Borrar</span>
                                            </MenuItem>
                                        </MenuItems>
                                    </Menu>
                                </div>
                            </div>
                            <div v-html="comment.comment"></div>
                        </div>
                    </div>
                </div>
            </DisclosurePanel> 
        </Disclosure>
    </div>

    <PublicacionDialog :publicacion="publicacion" v-model="showDialog" />
</template>