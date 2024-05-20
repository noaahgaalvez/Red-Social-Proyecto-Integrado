<template>
  <AuthenticatedLayout>
    <div class="container mx-auto">
      <div class="relative">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgTK5rMT1U1VzAVpuhz6z2krX_hYLUwik0VTTEmFPEPw&s" 
          class=" w-full h-[200px] object-cover">
        <img src="https://png.pngtree.com/png-vector/20191101/ourmid/pngtree-cartoon-color-simple-male-avatar-png-image_1934459.jpg" 
          class="absolute left-[64px] w-[128px] h-[128px] rounded-full -bottom-[48px]">
      </div>
        <div class="py-16 sm:px-0">
          <TabGroup>
            <TabList class="flex space-x-1 rounded-xl bg-blue-900/20 p-1">
              <Tab v-slot="{ selected }" as="template">
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
              <TabPanel
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
  import { ref } from 'vue'
  import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
  import {usePage} from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import TabItem from '@/Components/TabItem.vue';
  import Edit from '@/Pages/Profile/Edit.vue';

  defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
  });

  const user = usePage().props.auth.user;
  
  </script>
  