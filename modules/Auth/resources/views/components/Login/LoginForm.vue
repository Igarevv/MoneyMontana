<script setup lang="ts">

import {useForm} from "@inertiajs/vue3";
import Message from "primevue/message";
import InputText from "primevue/inputtext";

export interface IUserLogin {
  email: string;
  password: string;
}

const emit = defineEmits<{
  (e: 'user-logged-in', payload: IUserLogin): void;
}>();

const form = useForm({
  email: null,
  password: null,
  remember: false,
})
</script>

<template>
  <div class="w-full max-w-md p-8 space-y-6 dark:bg-primary-dark">
    <h2 class="text-2xl font-bold text-black dark:text-white text-center">{{ $t('login.title') }}</h2>

    <!--    <div class="flex space-x-4">
      <button
          class="flex items-center gap-2 w-full justify-center px-4 py-2 border cursor-pointer border-gray-600 dark:border-gray-400 rounded-lg text-sm text-black dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition"
      >
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5" />
        {{ $t('registration.register.signup_google') }}
      </button>
      <button
          class="flex items-center gap-2 w-full justify-center px-4 py-2 border cursor-pointer border-gray-600 dark:border-gray-400 rounded-lg text-sm text-black dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition"
      >
        <img src="https://www.svgrepo.com/show/512317/github-142.svg" alt="GitHub" class="w-5 h-5" />
        {{ $t('registration.register.signup_github') }}
      </button>
    </div>

    <div class="flex items-center justify-between text-black dark:text-white">
      <hr class="w-full border-gray-300 dark:border-gray-600" />
      <span class="px-3 text-sm">{{ $t('registration.register.or') }}</span>
      <hr class="w-full border-gray-300 dark:border-gray-600" />
    </div>-->

    <form @submit.prevent="form.post('/login')" class="space-y-4">
      <div class="flex flex-col gap-1">
        <label class="text-base text-black dark:text-white">{{ $t('login.labels.email') }}</label>
        <div class="rounded-xl">
          <InputText
              name="email"
              type="email"
              placeholder="your-email@dot.com"
              v-model="form.email"
              fluid
          />
        </div>
        <Message v-if="form.errors.email" severity="error" size="small" variant="simple">{{ form.errors.email }}</Message>
      </div>

      <div class="flex flex-col gap-1">
        <label class="text-base text-black dark:text-white">{{ $t('login.labels.password') }}</label>
        <div class="rounded-xl">
          <InputText
              name="password"
              type="password"
              placeholder="*********"
              v-model="form.password"
              fluid
          />
        </div>
        <Message v-if="form.errors.password" severity="error" size="small" variant="simple">{{ form.errors.password }}</Message>
      </div>

      <button
          type="submit"
          :disabled="form.processing"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded font-medium"
      >
        {{ $t('login.login_btn') }}
      </button>
    </form>

    <p class="text-sm text-gray-500 dark:text-gray-300 text-center">
      {{ $t('login.dont_have_account') }}
      <a href="#" class="text-blue-500 underline">{{ $t('login.register_here') }}</a>
    </p>
  </div>
</template>

<style scoped>
:deep(.p-inputtext::placeholder) {
  @apply text-gray-400
}
</style>