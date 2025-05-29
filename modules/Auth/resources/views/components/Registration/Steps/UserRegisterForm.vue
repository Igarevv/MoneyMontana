<script setup lang="ts">
import { Form } from '@primevue/forms';
import { reactive } from 'vue';
import { yupResolver } from '@primevue/forms/resolvers/yup';
import * as yup from 'yup';
import { InputText, Message } from 'primevue';

const props = defineProps<{
  nextStep: Function;
}>();

export interface IUserRegister {
  username: string;
  email: string;
  password: string;
  password_confirm: string;
}

const emit = defineEmits<{
  (e: 'user-created', payload: IUserRegister): void;
}>();

const initialValues = reactive<IUserRegister>({
  username: '',
  email: '',
  password: '',
  password_confirm: ''
});

const resolver = yupResolver(
    yup.object({
      username: yup.string().required('Username is required').min(3, 'Username must be at least 3 characters long'),
      email: yup.string().email('Invalid email address').required('Email is required'),
      password: yup.string().required('Password is required').min(6, 'Password must be at least 6 characters long'),
      password_confirm: yup
          .string()
          .oneOf([yup.ref('password')], 'Passwords must match')
          .required('Please confirm your password')
    })
);

const onFormSubmit = ({ valid, values }: { valid: boolean, values: IUserRegister }) => {
  props.nextStep(2);
  if (valid) {
    emit('user-created', values);
  }
};
</script>

<template>
  <div class="w-full max-w-md p-8 space-y-6">
    <h2 class="text-2xl font-bold text-black dark:text-white text-center">Your Best Tracker Starts Here</h2>
    <div class="flex space-x-4">
      <button
          class="flex items-center gap-2 w-full justify-center px-4 py-2 border cursor-pointer border-gray-600 dark:border-gray-400 rounded-lg text-sm text-black dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition"
      >
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5" />
        Sign up with Google
      </button>
      <button
          class="flex items-center gap-2 w-full justify-center px-4 py-2 border cursor-pointer border-gray-600 dark:border-gray-400 rounded-lg text-sm text-black dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition"
      >
        <img src="https://www.svgrepo.com/show/512317/github-142.svg" alt="GitHub" class="w-5 h-5" />
        Sign up with GitHub
      </button>
    </div>
    <div class="flex items-center justify-between text-black dark:text-white">
      <hr class="w-full border-gray-300 dark:border-gray-600" />
      <span class="px-3 text-sm">or</span>
      <hr class="w-full border-gray-300 dark:border-gray-600" />
    </div>
    <Form class="space-y-4" v-slot="$form" :initialValues :resolver="resolver" @submit="onFormSubmit">
      <div class="flex flex-col gap-1">
        <label class="text-base text-black dark:text-white">What should we call you?</label>
        <div class="rounded-xl">
          <InputText
              name="username"
              type="text"
              placeholder="Username"
              fluid
          />
        </div>
        <Message v-if="$form.username?.invalid" severity="error" size="small" variant="simple">{{ $form.username.error.message }}</Message>
      </div>

      <div class="flex flex-col gap-1">
        <label class="text-base text-black dark:text-white">Your email</label>
        <div class="rounded-xl">
          <InputText
              name="email"
              type="email"
              placeholder="john@doe.com"
              fluid
          />
        </div>
        <Message v-if="$form.email?.invalid" severity="error" size="small" variant="simple">{{ $form.email.error.message }}</Message>
      </div>

      <div class="flex flex-col gap-1">
        <label class="text-base text-black dark:text-white">Your password</label>
        <div class="rounded-xl">
          <InputText
              name="password"
              type="password"
              placeholder="**********"
              fluid
          />
        </div>
        <Message v-if="$form.password?.invalid" severity="error" size="small" variant="simple">{{ $form.password.error.message }}</Message>
      </div>

      <div class="flex flex-col gap-1">
        <label class="text-base text-black dark:text-white">Repeat your password</label>
        <div class="rounded-xl">
          <InputText
              name="password_confirm"
              type="password"
              placeholder="**********"
              fluid
          />
        </div>
        <Message v-if="$form.password_confirm?.invalid" severity="error" size="small" variant="simple">{{ $form.password_confirm.error.message }}</Message>
      </div>

      <div class="space-y-2">
        <label class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300">
          <input type="checkbox" class="form-checkbox rounded text-blue-500" />
          <span>
            By signing up, you agree to Money Montana's
            <a href="#" class="text-blue-500 underline">Terms of Use</a> and
            <a href="#" class="text-blue-500 underline">Privacy Policy</a>.
          </span>
        </label>
      </div>

      <button
          type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded font-medium"
      >
        Next Step
      </button>
    </Form>

    <p class="text-sm text-gray-500 dark:text-gray-300 text-center">
      Already have an account?
      <a href="#" class="text-blue-500 underline">Login here</a>
    </p>
  </div>
</template>

<style scoped>

</style>