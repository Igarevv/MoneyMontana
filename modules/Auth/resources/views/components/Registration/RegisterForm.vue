<template>
  <div class="card flex justify-center">
    <Stepper v-model:value="activeStep" class="basis-[40rem]">
      <StepPanels>
        <StepPanel v-slot="{ activateCallback }" :value="1">
          <Form :next-step="activateCallback" @user-created="onUserCreated"/>
        </StepPanel>
        <StepPanel v-slot="{ activateCallback }" :value="2">
          <UserPreferencesForm
              v-model:modelValueCountry="userPreferencesData.country"
              v-model:modelValueCurrency="userPreferencesData.currency"
          />
          <div class="flex pt-6 justify-between">
            <Button label="Back" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback(1)"/>
            <Button label="Register Now!" @click="onRegister"/>
          </div>
        </StepPanel>
        <StepPanel :value="3">
          <div class="flex flex-col gap-2 mx-auto" style="min-height: 16rem; max-width: 24rem">
            <div class="text-center mt-4 mb-4 text-xl font-semibold">Account created successfully</div>
            <div class="flex justify-center">
              <img alt="logo" src="https://primefaces.org/cdn/primevue/images/stepper/content.svg"/>
            </div>
          </div>
        </StepPanel>
      </StepPanels>
    </Stepper>
  </div>
</template>

<script setup lang="ts">
import {reactive, ref} from 'vue';
import {
  Stepper,
  StepPanel,
  Button,
  StepPanels,
} from "primevue";
import Form, {IUserRegister} from "@Modules/Auth/resources/views/components/Registration/Steps/UserRegisterForm.vue";
import UserPreferencesForm, {
  Country
} from "@Modules/Auth/resources/views/components/Registration/Steps/UserPreferencesForm.vue";
import {Language} from "@/Shared/Localization/DefaultSelectLocalization.vue";
import {SupportedLocales} from "@/i18n.config";
import {getCurrentTheme} from "@/Load/darkMode";
import {useLocaleChange} from "@/composables/useLocaleChange";
import {AuthService} from "@Modules/Auth/resources/views/services/AuthService";

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
  locale: SupportedLocales
}>({
  country: null,
  currency: null,
  theme: getCurrentTheme(),
  locale: useLocaleChange().currentLocale
});

const activeStep = ref(1);

const onUserCreated = (user: IUserRegister) => {
  userRegisterData.user = user;

  activeStep.value = 2;
};

const onRegister = () => {
  AuthService.register(
      { user: userRegisterData.user, preferences: userPreferencesData} as UserRegisterRequest,
      () => {
        console.log('data sent')
      },
      () => {

      },
      () => {
        activeStep.value = 3;
      }
  );
}
</script>
