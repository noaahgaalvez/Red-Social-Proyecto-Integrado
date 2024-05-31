<template>
  <AuthenticatedLayout>
    <div class="container mx-auto h-full overflow-auto">

      <div v-show="showNotification && props.success"
          class="my-2 py-2 px-3 font-medium text-sm bg-emerald-500 text-white">
          {{ success }}
      </div>
      <div v-if="errors.cover"
          class="my-2 py-2 px-3 font-medium text-sm bg-red-400 text-white">
          {{ errors.cover }}
      </div>

      <div class="group relative bg-white"> 
        <img :src="imgPortadaSrc || user.cover_url !== '/storage/' ? user.cover_url : '/img/default_PortadaUsuario.jpg'"
          class=" w-full h-[200px] object-cover">
        <button class="absolute top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg text-sm opacity-0 group-hover:opacity-100">
          Actualizar portada
          <input type="file" class="absolute left-0 top-0 bottom-0 right-0 opacity-0 cursor-pointer"
                @change="actualizarPortada" />
        </button>
        <div class="flex">
          <img :src="imgPerfilSrc || user.avatar_url !== '/storage/' ? user.avatar_url : '/img/default_PerfilUsuario.jpg'"
              class="ml-[48px] w-[128px] h-[128px] -mt-[64px] rounded-full">
          <div class="relative flex-1 p-4 flex justify-between items-center relative">
              <h1 class="text-2xl font-bold">
                {{ props.user.name }}
              </h1>
              <button class="absolute bg-blue-500 text-white px-4 py-2 rounded-lg text-sm opacity-0 group-hover:opacity-100 absolute right-4">
                Actualizar foto de perfil
                <input type="file" class="absolute left-0 top-0 bottom-0 right-0 opacity-0 cursor-pointer"
                      @change="actualizarImagenPerfil" />
              </button>
          </div>
        </div>
      </div>
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
                <TabItem :selected="selected" text="Siguiendo" />
              </Tab>
              <Tab v-if="isMyProfile" v-slot="{ selected }" as="template" >
                <TabItem :selected="selected" text="Editar Perfil" />
              </Tab>
            </TabList>
      
            <TabPanels class="mt-2">
              <TabPanel
              :class="[
                  'rounded-xl bg-white p-3 shadow',
                  'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]">
                Publicaciones
              </TabPanel>
              <TabPanel
                :class="[
                  'rounded-xl bg-white p-3 shadow',
                  'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]">
                Seguidores
              </TabPanel>
              <TabPanel
              :class="[
                  'rounded-xl bg-white p-3 shadow',
                  'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]">
                Seguidos
              </TabPanel>
            </TabPanels>
            <TabPanel v-if="isMyProfile"
              :class="[
                'rounded-xl bg-white p-3 shadow',
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

  const imagesForm = useForm({
    portada : null,
    imagenPerfil : null
  });

  const authUser = usePage().props.auth.user;
  const showNotification = ref(true);
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
  
  </script>
  