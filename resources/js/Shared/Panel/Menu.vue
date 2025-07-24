<template>
  <ul class="list-none p-4 m-0">
    <SidebarMenuItems
        v-for="(item, index) in menu"
        :key="index"
        :item="item"
    />
  </ul>
</template>

<script setup lang="ts">
import SidebarMenuItems from "@/Shared/Panel/SidebarMenuItems.vue";
import {useI18n} from "vue-i18n";

const {tm} = useI18n();

const menu = tm('sidebar.menu');

/*
const menu = ref([
  {
    label: 'FAVORITES',
    children: [
      { label: 'Dashboard', icon: 'pi pi-home' },
      { label: 'Bookmarks', icon: 'pi pi-bookmark' },
      {
        label: 'Reports',
        icon: 'pi pi-chart-line',
        isOpen: false,
        children: [
          {
            label: 'Revenue',
            icon: 'pi pi-chart-line',
            isOpen: false,
            children: [
              { label: 'View', icon: 'pi pi-table' },
              { label: 'Search', icon: 'pi pi-search' }
            ]
          },
          { label: 'Expenses', icon: 'pi pi-chart-line' }
        ]
      },
      { label: 'Team', icon: 'pi pi-users' },
      { label: 'Messages', icon: 'pi pi-comments', badge: 3 },
      { label: 'Calendar', icon: 'pi pi-calendar' },
      { label: 'Settings', icon: 'pi pi-cog' }
    ]
  },
  {
    label: 'APPLICATION',
    children: [
      { label: 'Projects', icon: 'pi pi-folder' },
      { label: 'Performance', icon: 'pi pi-chart-bar' },
      { label: 'Settings', icon: 'pi pi-cog' }
    ]
  }
])
*/

</script>
