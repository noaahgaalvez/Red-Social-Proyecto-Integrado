<template>
  <AuthenticatedLayout>
    <div class="container mx-auto h-full overflow-auto">

      <!-- Notificaciones -->
      <div v-show="showNotification && props.success"
          class="my-2 py-2 px-3 font-medium text-sm bg-emerald-500 text-white">
          {{ success }}
      </div>
      <div v-if="errors.cover"
          class="my-2 py-2 px-3 font-medium text-sm bg-red-400 text-white">
          {{ errors.cover }}
      </div>

      <!-- Imágenes e información de usuario -->
      <div class="group relative bg-white dark:bg-gray-700 dark:text-gray-200">
        <img :src="imgPortadaSrc || user.cover_url !== '/storage/' ? user.cover_url : '/img/default_PortadaUsuario.jpg'"
          class=" w-full h-[200px] object-cover">

        <div v-if="isMyProfile">
          <button class="absolute top-4 right-4 bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm opacity-0 group-hover:opacity-100">
            Actualizar portada
            <input type="file" class="absolute left-0 top-0 bottom-0 right-0 opacity-0 cursor-pointer"
                  @change="actualizarPortada" />
          </button>
          <button class="absolute top-14 right-4 bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm opacity-0 group-hover:opacity-100">
            Actualizar foto de perfil
            <input type="file" class="absolute left-0 top-0 bottom-0 right-0 opacity-0 cursor-pointer"
              @change="actualizarImagenPerfil" />
          </button>
        </div>

        <div class="flex">
          <img :src="imgPerfilSrc || user.avatar_url !== '/storage/' ? user.avatar_url : '/img/default_PerfilUsuario.jpg'"
              class="ml-[48px] w-[128px] h-[128px] -mt-[64px] rounded-full aspect-square object-cover">
          <div class="relative flex-1 p-4 flex justify-between items-center relative">
            <div>
              <h1 class="text-2xl font-bold">{{ props.user.name }}</h1>
              <p class="text-gray-500 dark:text-gray-400 text-sm">{{ props.numFollowers }} seguidores - {{ props.numFollowing }} siguiendo</p>
            </div>
            
            <!-- Botón de seguir usuario -->
            <div v-if="!isMyProfile">
              <button @click="seguirUsuario" v-if="!props.isFollower"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-500">
                Seguir Usuario
              </button>
              <button v-else @click="seguirUsuario"
                class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-500">
                Dejar de seguir
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs -->
        <div class="py-16 sm:px-0">
          <TabGroup>
            <TabList class="flex space-x-1 rounded-xl bg-blue-900/20 p-1">
              <Tab v-slot="{ selected }" as="template">
                <TabItem :selected="selected" text="Publicaciones" />
              </Tab>
              <Tab v-slot="{ selected }" as="template">
                <TabItem :selected="selected" text="Seguidores" />
              </Tab>
              <Tab v-slot="{ selected }" as="template">
                <TabItem :selected="selected" text="Seguidos" />
              </Tab>
              <Tab v-if="isMyProfile" v-slot="{ selected }" as="template" >
                <TabItem :selected="selected" text="Editar Perfil" />
              </Tab>
            </TabList>
      
            <TabPanels class="mt-2">
              <TabPanel
              :class="[
                  'rounded-xl bg-white p-3 shadow dark:bg-gray-800',
                  'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]">
                <PublicacionList :posts="posts.data" />
              </TabPanel>
              <TabPanel
                :class="[
                  'rounded-xl bg-white p-3 shadow dark:bg-gray-700',
                  'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]">
                <SeguidoresList :usuarios="followers.data" />
              </TabPanel>
              <TabPanel
              :class="[
                  'rounded-xl bg-white p-3 shadow dark:bg-gray-700',
                  'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]">
                <SeguidosList :usuarios="followings.data" />
              </TabPanel>
            </TabPanels>
            <TabPanel v-if="isMyProfile"
              :class="[
                'rounded-xl bg-white p-3 shadow dark:bg-gray-700',
                'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
              ]">
              <Edit :must-verify-email="mustVerifyEmail" :status="status" />
            </TabPanel>
          </TabGroup>
        </div>
    </div>
  </AuthenticatedLayout>
</template>
  
<script setup>
  import { computed, ref } from 'vue'
  import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
  import {usePage} from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import TabItem from '@/Components/TabItem.vue';
  import Edit from '@/Pages/Profile/Edit.vue';
  import { useForm } from '@inertiajs/vue3';
  import PublicacionList from '@/Components/app/PublicacionList.vue';
  import SeguidosList from '@/Components/app/SeguidosList.vue';
  import SeguidoresList from '@/Components/app/SeguidoresList.vue';

  const imagesForm = useForm({
    portada : null,
    imagenPerfil : null
  });
  
  const showNotification = ref(true);
  const authUser = usePage().props.auth.user;
  const isMyProfile = computed(() => authUser && authUser.id === props.user.id);

  const props = defineProps({
    errors: Object,
    mustVerifyEmail: {
        type: Boolean,
    },
    success: {
        type: String,
    },
    status: {
        type: String,
    },
    isFollower: Boolean,
    posts: Object,
    followers: Object,
    numFollowers: Number,
    followings: Object,
    numFollowing: Number,
    user: {
      type: Object
    }
  });

  const imgPortadaSrc = ref('');
  const imgPerfilSrc = ref('');

  function actualizarPortada(e) {
    imagesForm.portada = e.target.files[0];

    if (imagesForm.portada) {
      const reader = new FileReader();
      reader.onload = (e) => {
        imgPortadaSrc.value = reader.result;
      }
      reader.readAsDataURL(imagesForm.portada);

      imagesForm.post(route('profile.actualizarImagen'), {
        onSuccess: () => {
          showNotification.value = true;
          setTimeout(() => {
            showNotification.value = false;
          }, 3000);

        }
      });
    }
  }

  function actualizarImagenPerfil(e) {
    imagesForm.imagenPerfil = e.target.files[0];

    if (imagesForm.imagenPerfil) {
      const reader = new FileReader();
      reader.onload = (e) => {
        imgPerfilSrc.value = reader.result;
      }
      reader.readAsDataURL(imagesForm.imagenPerfil);

      imagesForm.post(route('profile.actualizarImagen'), {
        onSuccess: () => {
          showNotification.value = true;
          setTimeout(() => {
            showNotification.value = false;
          }, 3000);

        }
      });
    }
  }

  function seguirUsuario() {
    const form = useForm({
      follow: !props.isFollower
    });

    form.post(route('user.seguir', props.user.id), {
      onSuccess: () => {
        console.log('Usuario seguido');
        showNotification.value = true;
        setTimeout(() => {
          showNotification.value = false;
        }, 3000);
      }
    });
  }
  
  </script>
  