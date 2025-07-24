<script setup lang="ts">
import PanelSidebar from "@/Shared/Panel/PanelSidebar.vue";
import Header from "@/Shared/Panel/Header.vue";
import {provide, ref} from "vue";
import Footer from "@/Shared/Panel/Footer.vue";
import {usePreferences} from "@/composables/usePreferences";

const visible = ref(false);

defineProps({
  title: {
    type: String,
  }
});

provide('visible', visible);

usePreferences();
</script>

<template>
  <div class="min-h-screen flex flex-col relative overflow-hidden">
    <Header :title="title"/>

    <div class="flex flex-1 relative">
      <PanelSidebar/>

      <main class="flex-1 p-6 relative z-10 overflow-hidden bg-panel-primary-bg">
        <div class="absolute inset-0 -z-10 pointer-events-none">
          <div class="dark:hidden">
            <div class="w-[500px] h-[500px] bg-[#fcb69f]/30 rounded-full blur-[200px] absolute top-10 left-[40%]"></div>
            <div
                class="w-[400px] h-[400px] bg-[#c2e9fb]/30 rounded-full blur-[200px] absolute bottom-20 right-[20%]"></div>
            <div
                class="w-[600px] h-[600px] bg-[#b4eff1]/50 rounded-full blur-[250px] absolute top-[60%] left-[10%]"></div>
          </div>

          <div class="hidden dark:block">
            <div
                class="w-[700px] h-[700px] bg-[#4e4376]/40 rounded-full blur-[300px] absolute top-[20%] left-[20%]"></div>
            <div
                class="w-[600px] h-[600px] bg-[#0f2027]/40 rounded-full blur-[300px] absolute bottom-[10%] right-[10%]"></div>
            <div
                class="w-[500px] h-[500px] bg-[#00c9ff]/20 rounded-full blur-[250px] absolute bottom-[40%] left-[60%]"></div>
          </div>
        </div>

        <div class="relative z-10">
          <slot/>
        </div>
      </main>
    </div>

    <Footer/>
  </div>
</template>

