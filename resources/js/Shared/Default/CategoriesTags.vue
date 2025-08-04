<script setup lang="ts">
import {ref} from "vue"

const props = defineProps<{
  categories: CategoriesTags[]
}>()

export type CategoriesTags = {
  id: number
  label: string
  color: string
}

const selectedCategories = ref<CategoriesTags[]>([]);

function toggleTag(tag: CategoriesTags) {
  const exists = selectedCategories.value.find(t => t.id === tag.id);

  if (exists) {
    selectedCategories.value = selectedCategories.value.filter(t => t.id !== tag.id);
  } else {
    selectedCategories.value.push(tag);
  }
}

</script>


<template>
  <div class="flex flex-wrap gap-2">
    <div
        v-for="tag in categories"
        :key="tag.id"
        class="p-2"
        :class="[
            selectedCategories.some(t => t.id === tag.id) ? 'ring-2 ring-offset-2 ring-primary-500'  : '',
            'cursor-pointer', `bg-${tag.color}`
        ]"
        @click="toggleTag(tag)"
    >
    </div>
  </div>
</template>

<style scoped>

</style>