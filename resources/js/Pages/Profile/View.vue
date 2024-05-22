<template>
  <AuthenticatedLayout>
    <div class="container mx-auto h-full overflow-auto">
      <div class="group relative bg-white">
        <img src="" 
          class=" w-full h-[200px] object-cover">
        <button class="absolute top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg text-sm opacity-0 group-hover:opacity-100">
          Actualizar portada
          <input type="file" class="absolute left-0 top-0 bottom-0 right-0 opacity-0 cursor-pointer"
                @change="actualizarPortada" />
        </button>
        <div class="flex">
          <img src="https://png.pngtree.com/png-vector/20191101/ourmid/pngtree-cartoon-color-simple-male-avatar-png-image_1934459.jpg" 
              class="ml-[48px] w-[128px] h-[128px] -mt-[64px] rounded-full">
          <div class="flex-1 p-4 flex justify-between items-center">
              <h1 class="text-2xl font-bold">
                {{ props.user.name }}
              </h1>
          </div>
        </div>
      </div>
        <div class="py-16 sm:px-0">
          <TabGroup>
            <TabList class="flex space-x-1 rounded-xl bg-blue-900/20 p-1">
              <Tab v-if="isMyProfile" v-slot="{ selected }" as="template" >
                <TabItem :selected="selected" text="Perfil" />
              </Tab>
              <Tab v-slot="{ selected }" as="template">
                <TabItem :selected="selected" text="Publicaciones" />
              </Tab>
              <Tab v-slot="{ selected }" as="template">
                <TabItem :selected="selected" text="Seguidores" />
              </Tab>
              <Tab v-slot="{ selected }" as="template">
                <TabItem :selected="selected" text="Siguiendo" />
              </Tab>
            </TabList>
      
            <TabPanels class="mt-2">
              <TabPanel v-if="isMyProfile"
                :class="[
                  'rounded-xl bg-white p-3 shadow',
                  'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                ]">
                <Edit :must-verify-email="mustVerifyEmail" :status="status" />
              </TabPanel>
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

  const authUser = usePage().props.auth.user;

  const isMyProfile = computed(() => authUser && authUser.id === props.user.id);

  const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
      type: Object
    }
  });

  const imgPortadaSrc = ref('');

  function actualizarPortada(e) {
    console.log(e);
    const file = e.target.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        imgPortadaSrc.value = e.target.result;
      }
      reader.readAsDataURL(file);
    }
  }
  
  </script>
  