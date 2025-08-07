<script setup lang="ts">
import Drawer from "primevue/drawer";
import {computed, defineAsyncComponent, provide, ref, watch} from "vue";
import ExpenseTypeSelector, {
  ExpenseType
} from "@Modules/ExpenseAccount/resources/views/components/Expenses/Add/ExpenseTypeSelector.vue";
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import axios from "axios";
import {useForm} from "@inertiajs/vue3";
import {TCategoriesTags} from "@Modules/ExpenseAccount/resources/views/shared/Categories/CategoriesTags.vue";
import Message from "primevue/message";
import Button from "primevue/button";
import {usePreferences} from "@/composables/usePreferences";

const visibleRight = ref(false);

const categories = ref<TCategoriesTags[]>([]);

const DisposablePanel = defineAsyncComponent(() => import('./DisposablePanel.vue'));

function autoResize(event: Event) {
  const textarea = event.target as HTMLTextAreaElement;

  textarea.style.height = 'auto';

  textarea.style.height = textarea.scrollHeight + 'px';
}

const selected = ref<ExpenseType>(ExpenseType.DISPOSABLE);

const form = useForm({
  label: '',
  description: '',
  created_at: new Date(),
  duration_type: '',
  duration_value: '',
  amount: '',
  currency: usePreferences().currency,
  categories: [],
  type: 'disposable'
})

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

provide('categories', categories);

async function openDrawerRight() {
  visibleRight.value = true;

  await axios.get('/api/montana/expense-categories')
      .then((response) => {
        categories.value = response.data.data.attributes;
      })
      .catch((error) => {

      })
}

function submit() {
  form.post('/montana/expense-accounting', {
    preserveScroll: true
  })
}

watch(selected, (value) => {
  switch (value) {
    case ExpenseType.DISPOSABLE:
      form.type = 'disposable'
      break
    case ExpenseType.SUBSCRIPTION:
      form.type = 'subscription'
      break
    case ExpenseType.REPEATABLE:
      form.type = 'repeatable'
      break
  }
})
</script>

<template>
  <div
      @click="openDrawerRight"
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
    <template #container="{ closeCallback }">
      <form @submit.prevent="submit" class="flex flex-col h-full">
        <div class="flex flex-col h-full">
          <div class="relative w-full">
            <div class="w-full m-8 !mb-0 space-y-4">
              <div class="flex flex-col gap-2">
              <textarea
                  v-model="form.label"
                  :placeholder="$t('panel.expense_accounting.all_expenses.add_form.input_label')"
                  rows="1"
                  class="resize-none w-full placeholder-gray-500 outline-none border-none bg-transparent text-3xl font-semibold placeholder:font-normal overflow-hidden pr-12"
                  @input="autoResize"
              />
                <Message time="5000" severity="error" size="small" variant="simple" v-if="form.errors.label">{{
                    form.errors.label
                  }}
                </Message>
              </div>
              <div class="flex flex-col gap-2">
              <textarea
                  v-model="form.description"
                  :placeholder="$t('panel.expense_accounting.all_expenses.add_form.input_description')"
                  rows="2"
                  class="resize-none w-full placeholder-gray-500 outline-none border-none bg-transparent text-xl placeholder:font-normal overflow-hidden pr-12"
                  @input="autoResize"
              />
                <Message time="5000" severity="error" size="small" variant="simple" v-if="form.errors.description">{{
                    form.errors.description
                  }}
                </Message>
              </div>
            </div>
            <button
                @click="visibleRight = false"
                class="absolute top-0 right-0 text-gray-500 hover:text-black text-xl"
            >
              <i class="pi pi-times"></i>
            </button>
          </div>

          <Tabs :value="tabIndex">
            <TabList>
              <ExpenseTypeSelector v-model:selected="selected"/>
            </TabList>

            <TabPanels class="m-8 !p-0">
              <TabPanel :value="0">
                <disposable-panel :form="form"/>
              </TabPanel>
              <TabPanel :value="1">Subscription content</TabPanel>
              <TabPanel :value="2">Repeatable content</TabPanel>
            </TabPanels>
          </Tabs>
        </div>
        <div class="mt-auto mb-4 me-4">
          <div class="flex w-full justify-end">
            <Button size="small" type="submit" :loading="form.processing" severity="contrast">
              {{ $t('panel.expense_accounting.all_expenses.add') }}
            </Button>
          </div>
        </div>
      </form>
    </template>
  </Drawer>
</template>

<style scoped>

</style>
