<script setup lang="ts">
import {inject, Ref, ref, watch} from "vue"
import Button from "primevue/button"
import AddNewCategory from "@Modules/ExpenseAccount/resources/views/shared/Categories/AddNewCategory.vue";
import Popover from "primevue/popover"

export type TCategoriesTags = {
  id: number
  label: string
  color: string
}

const op = ref();

const emit = defineEmits(['selected-categories']);

const categories = inject<Ref<TCategoriesTags[]>>('categories');

if (!categories) {
  throw new Error("categories not provided");
}

const selectedCategories = ref<TCategoriesTags[]>([]);

const toggleCategoryCreate = (event) => {
  op.value.toggle(event);
}

const handleNewCategoryAdded = (category?: TCategoriesTags) => {
  op.value.hide();

  if (category) {
    categories.value.push(category);
  }
}

function toggleTag(tag: TCategoriesTags) {
  const exists = selectedCategories.value.find(t => t.id === tag.id);

  if (exists) {
    selectedCategories.value = selectedCategories.value.filter(t => t.id !== tag.id);
  } else {
    if (selectedCategories.value.length >= 2) {
      return;
    }

    selectedCategories.value.push(tag);
  }
}

watch(() => selectedCategories.value, () => {
  emit('selected-categories', selectedCategories.value.map((category) => category.id));
}, {deep: true})
</script>


<template>
  <div class="flex flex-wrap gap-2">
    <div
        v-for="tag in categories"
        :key="tag.id"
        class="p-2 rounded-lg text-xs"
        :style="{ backgroundColor: tag.color }"
        :class="[
          selectedCategories.some(t => t.id === tag.id)
            ? 'ring-2 ring-primary-500'
            : selectedCategories.length >= 2
            ? 'opacity-50 pointer-events-none'
            : '',
            'cursor-pointer',
        ]"

        @click="toggleTag(tag)"
    >
      {{ tag.label }}
    </div>
    <Button
        ref="categoryButtonRef"
        icon="pi pi-plus"
        size="small"
        rounded
        severity="secondary"
        @click="toggleCategoryCreate"
    />
  </div>
  <Popover ref="op">
    <AddNewCategory ref="categoryPopoverRef" @new-category="handleNewCategoryAdded"/>
  </Popover>
</template>

<style scoped>

</style>