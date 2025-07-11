<template>
  <div class="card flex justify-center">
    <Stepper v-model:value="activeStep" class="basis-[40rem]">
      <StepPanels>
        <StepPanel v-slot="{ activateCallback }" :value="1">
          <Form
              :next-step="activateCallback"
              @user-created="onUserCreated"
              :errors="userValidationErrors"
          />
        </StepPanel>
        <StepPanel v-slot="{ activateCallback }" :value="2">
          <UserPreferencesForm
              :next-step="activateCallback"
              @register="onRegister"
              :errors="preferencesValidationErrors"
          />
        </StepPanel>
        <StepPanel :value="3">
          <div class="flex flex-col gap-5 items-center justify-center" style="min-height: 16rem; max-width: 24rem">
            <template v-if="registrationSuccess">
              <svg xmlns="http://www.w3.org/2000/svg" class="size-20" fill="#16a34a" viewBox="0 0 24 24"><title>check-circle</title><path d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z" /></svg>
              <h3 class="text-center text-xl">Success! Redirecting you...</h3>
            </template>
            <template v-else-if="registrationFailed">
              <svg xmlns="http://www.w3.org/2000/svg" fill="#dc2626" class="size-20" viewBox="0 0 24 24"><title>alert-circle-outline</title><path d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20Z" /></svg>
              <h3 class="text-center text-xl">Unknown error occurred while registration. Please, contact us.</h3>
            </template>
            <template v-else>
              <ProgressSpinner />
              <h3 class="text-center text-xl">Registering your account...</h3>
            </template>
          </div>
        </StepPanel>
      </StepPanels>
    </Stepper>
  </div>
</template>

<script setup lang="ts">
import {reactive, ref} from 'vue';
import Stepper from "primevue/stepper";
import StepPanel from "primevue/steppanel";
import StepPanels from "primevue/steppanels";
import Form, {IUserRegister} from "@Modules/Auth/resources/views/components/Registration/Steps/UserRegisterForm.vue";
import UserPreferencesForm from "@Modules/Auth/resources/views/components/Registration/Steps/UserPreferencesForm.vue";
import {SupportedLocales} from "@/i18n.config";
import {getCurrentTheme} from "@/Load/darkMode";
import {useLocaleChange} from "@/composables/useLocaleChange";
import ProgressSpinner from "primevue/progressspinner"
import {AuthService} from "@Modules/Auth/resources/views/services/AuthService";
import { router } from '@inertiajs/vue3'

export interface UserRegisterRequest {
  user: IUserRegister,
  preferences: {
    country: string | null,
    currency: string | null,
    theme: string,
    locale: SupportedLocales
  }
}

const userRegisterData = reactive<{
  user: IUserRegister | null
}>({
  user: null
});

const userPreferencesData = reactive<{
  country: string | null,
  currency: string | null,
  theme: string,
  locale: SupportedLocales,
  employment_type: string | null
}>({
  country: null,
  currency: null,
  theme: getCurrentTheme(),
  locale: useLocaleChange().currentLocale,
  employment_type: null
});

const registrationSuccess = ref(false);

const registrationFailed = ref(false);

const activeStep = ref(1);

const preferencesValidationErrors = ref({});

const userValidationErrors = ref({});

const onUserCreated = (user: IUserRegister) => {
  userRegisterData.user = user;

  activeStep.value = 2;
};

const onRegister = (preferences: { currency: string, country: string, employmentType: string }) => {
  userPreferencesData.country = preferences.country;

  userPreferencesData.currency = preferences.currency;

  userPreferencesData.employment_type = preferences.employmentType;

  AuthService.register(
      { user: userRegisterData.user, preferences: userPreferencesData} as UserRegisterRequest,
      () => {
        registrationSuccess.value = true;

        setTimeout(() => router.visit('/login'), 500);
      },
      (errors) => {
        registrationSuccess.value = false;

        if (errors?.status) {
          registrationFailed.value = true;

          return;
        }

        if (['username', 'email', 'password'].some(key => !!errors?.[key])) {
          activeStep.value = 1;

          userValidationErrors.value = errors;
        } else {
          activeStep.value = 2;

          preferencesValidationErrors.value = errors;
        }
      },
      () => {
        activeStep.value = 3;
      }
  );
}
</script>
