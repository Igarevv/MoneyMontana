<script setup lang="ts">
import PanelSidebar from "@/Shared/Panel/PanelSidebar.vue";
import Header from "@/Shared/Panel/Header.vue";
import {provide, ref} from "vue";
import Footer from "@/Shared/Panel/Footer.vue";

const visible = ref(false);

provide('visible', visible);
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <Header/>

    <div class="flex flex-1">
      <panel-sidebar/>

      <main class="flex-1 p-6 bg-white dark:bg-gray-800">
        <slot />
      </main>
    </div>

    <Footer/>
  </div>
</template>
