<template>
  <li>
    <div
        v-if="item.children"
        @click="toggle"
        class="p-4 flex items-center justify-between cursor-pointer text-surface-500 dark:text-surface-400"
    >
      <span class="font-medium">{{ item.label }}</span>
      <i class="pi pi-chevron-down" :class="{ 'rotate-180': item.isOpen }"></i>
    </div>

    <Link
        v-else
        :href="item.route"
        class="flex items-center p-4 rounded cursor-pointer hover:bg-surface-100 dark:hover:bg-surface-800 duration-150"
        v-ripple
        @click="closeSidebar"
        :class="{
            'bg-primary-yellow/50': currentUrl === item.route,
            'hover:bg-surface-100 dark:hover:bg-surface-800 text-surface-500 dark:text-surface-400': currentUrl !== item.route
        }"
    >
      <i :class="item.icon + ' mr-2'"></i>
      <span class="font-medium">{{ item.label }}</span>
      <span
          v-if="item.badge"
          class="ml-auto bg-primary text-primary-contrast rounded-full inline-flex items-center justify-center"
          style="min-width: 1.5rem; height: 1.5rem"
      >{{ item.badge }}</span>
    </Link>

    <transition name="slide">
      <ul
          v-if="item.children && item.isOpen"
          class="list-none py-0 pl-4 pr-0 m-0 overflow-hidden"
      >
        <SidebarMenuItem
            v-for="(child, index) in item.children"
            :key="index"
            :item="child"
        />
      </ul>
    </transition>
  </li>
</template>

<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3'
import {computed, inject, Ref} from "vue";

const page = usePage();

const currentUrl = computed(() => page.url);

const props = defineProps({
  item: {
    type: Object,
    required: true
  }
})

const sidebarVisible = inject('visible') as Ref<boolean>;

function closeSidebar() {
  if (sidebarVisible) {
    sidebarVisible.value = false;
  }
}

function toggle() {
  props.item.isOpen = !props.item.isOpen
}
</script>

<style scoped>
.slide-enter-from,
.slide-leave-to {
  height: 0;
  opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}
</style>
