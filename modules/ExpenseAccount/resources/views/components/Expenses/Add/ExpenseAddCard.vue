<script setup lang="ts">
import Drawer from "primevue/drawer";
import {computed, defineAsyncComponent, ref} from "vue";
import ExpenseTypeSelector, {
  ExpenseType
} from "@Modules/ExpenseAccount/resources/views/components/Expenses/Add/ExpenseTypeSelector.vue";
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';

const visibleRight = ref(false);

const DisposablePanel = defineAsyncComponent(() => import('./DisposablePanel.vue'));

function autoResize(event: Event) {
  const textarea = event.target as HTMLTextAreaElement;

  textarea.style.height = 'auto';

  textarea.style.height = textarea.scrollHeight + 'px';
}

const selected = ref<ExpenseType>(ExpenseType.DISPOSABLE)

const tabIndex = computed(() => {
  switch (selected.value) {
    case ExpenseType.DISPOSABLE:
      return 0
    case ExpenseType.SUBSCRIPTION:
      return 1
    case ExpenseType.REPEATABLE:
      return 2
  }
})
</script>

<template>
  <div
      @click="visibleRight = true"
      class="flex items-center justify-center bg-white dark:bg-surface-900 border border-dashed border-gray-300 dark:border-dark-primary-gray hover:bg-primary-yellow/5 cursor-pointer transition-all duration-200 rounded-2xl p-8 min-h-[150px]"
  >
    <div
        class="flex flex-col items-center gap-2 text-surface-500 dark:text-surface-400 hover:text-primary transition-colors duration-200">
      <i class="pi pi-plus text-2xl"></i>
      <span class="font-medium text-sm">{{ $t('panel.expense_accounting.all_expenses.add') }}</span>
    </div>
  </div>

  <Drawer v-model:visible="visibleRight" header="" position="right" :show-close-icon="false"
          class="!w-full md:!w-[30rem] lg:!w-[50rem] rounded-s-xl">
    <template #header>
      <div class="relative w-full">
        <div class="w-full m-8 !mb-0 space-y-4">
          <textarea
              :placeholder="$t('panel.expense_accounting.all_expenses.add_form.input_label')"
              rows="1"
              class="resize-none w-full placeholder-gray-500 outline-none border-none bg-transparent text-3xl font-semibold placeholder:font-normal overflow-hidden pr-12"
              @input="autoResize"
          />
          <textarea
              :placeholder="$t('panel.expense_accounting.all_expenses.add_form.input_description')"
              rows="2"
              class="resize-none w-full placeholder-gray-500 outline-none border-none bg-transparent text-xl placeholder:font-normal overflow-hidden pr-12"
              @input="autoResize"
          />
        </div>
        <button
            @click="visibleRight = false"
            class="absolute top-0 right-0 text-gray-500 hover:text-black text-xl"
        >
          <i class="pi pi-times"></i>
        </button>
      </div>
    </template>
    <template #default>
      <Tabs :value="tabIndex">
        <TabList>
          <ExpenseTypeSelector v-model:selected="selected"/>
        </TabList>

        <TabPanels class="m-8 !p-0">
          <TabPanel :value="0">
            <disposable-panel/>
          </TabPanel>
          <TabPanel :value="1">Subscription content</TabPanel>
          <TabPanel :value="2">Repeatable content</TabPanel>
        </TabPanels>
      </Tabs>
    </template>
  </Drawer>
</template>

<style scoped>

</style>
