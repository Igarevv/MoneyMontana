<template>
  <div class="card flex justify-center">
    <Stepper v-model:value="activeStep" class="basis-[40rem]">
      <StepPanels>
        <StepPanel v-slot="{ activateCallback }" :value="1">
          <Form :next-step="activateCallback" @user-created="onUserCreated"/>
        </StepPanel>
        <StepPanel v-slot="{ activateCallback }" :value="2">
          <UserPreferencesForm/>
          <div class="flex pt-6 justify-between">
            <Button label="Back" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback(1)"/>
            <Button label="Next" icon="pi pi-arrow-right" iconPos="right" @click="activateCallback(3)"/>
          </div>
        </StepPanel>
        <StepPanel v-slot="{ activateCallback }" :value="3">
          <div class="flex flex-col gap-2 mx-auto" style="min-height: 16rem; max-width: 24rem">
            <div class="text-center mt-4 mb-4 text-xl font-semibold">Account created successfully</div>
            <div class="flex justify-center">
              <img alt="logo" src="https://primefaces.org/cdn/primevue/images/stepper/content.svg"/>
            </div>
          </div>
          <div class="flex pt-6 justify-start">
            <Button label="Back" severity="secondary" icon="pi pi-arrow-left" @click="activateCallback(2)"/>
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
import UserPreferencesForm from "@Modules/Auth/resources/views/components/Registration/Steps/UserPreferencesForm.vue";

const userRegisterData = reactive<{
  user: IUserRegister | null
}>({
  user: null
});

const activeStep = ref(1);

const onUserCreated = (user: IUserRegister) => {
  userRegisterData.user = user;

  activeStep.value = 2;
};
</script>
