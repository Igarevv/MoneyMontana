<script setup lang="ts">
import {ref, onMounted, nextTick} from 'vue';
import AppLogoLight from "@/Shared/AppLogoLight.vue";

const icons = [
  'pi-wallet',
  'pi-money-bill',
  'pi-credit-card',
  'pi-pound',
  'pi-dollar'
];

interface FallingIcon {
  id: number;
  icon: string;
  left: string;
  size: string;
  duration: number;
  delay: number;
  opacity: number;
}

const gradients: Array<string> = [
    'from-[#544a7d] to-[#ffd452]',
    'from-[#108dc7] to-[#ef8e38]',
    'from-[#22c1c3] to-[#fdbb2d]',
    'from-[#EB5757] to-[#000000]',
    'from-[#34e89e] to-[#0f3443]',
    'from-[#F3904F] to-[#3B4371]',
    'from-[#3494E6] to-[#EC6EAD]',
    'from-[#3a6186] to-[#89253e]',
    'from-[#2C3E50] to-[#FD746C]',
    'from-[#536976] to-[#292E49]',
    'from-[#43C6AC] to-[#191654]',
    'from-[#1d4350] to-[#a43931]',
];

const fallingIcons = ref<FallingIcon[]>([]);

const randomGradient = gradients[Math.floor(Math.random() * gradients.length)];

const animationStarted = ref(false);

function randomBetween(min: number, max: number) {
  return Math.random() * (max - min) + min;
}

onMounted(async () => {
  const count = 20;

  for (let i = 0; i < count; i++) {
    fallingIcons.value.push({
      id: i,
      icon: icons[Math.floor(Math.random() * icons.length)],
      left: `${randomBetween(0, 100)}%`,
      size: `${randomBetween(1, 2.5)}rem`,
      duration: randomBetween(6, 12),
      delay: randomBetween(0, 12),
      opacity: randomBetween(0.4, 0.9),
    });
  }

  await nextTick();

  setTimeout(() => {
    animationStarted.value = true;
  }, 50);
});
</script>

<template>
  <div
      :class="['bg-gradient-to-tr', randomGradient]"
      class="flex flex-col min-h-screen bg-gradient-to-tr text-white relative overflow-hidden">

    <div class="absolute inset-0 pointer-events-none">
      <i
          v-for="icon in fallingIcons"
          :key="icon.id"
          :class="['pi', icon.icon, 'falling-icon', { 'animate': animationStarted }]"
          :style="{
            '--left': icon.left,
            '--size': icon.size,
            '--duration': `${icon.duration}s`,
            '--delay': `${icon.delay}s`,
            '--opacity': icon.opacity,
          }"
      ></i>
    </div>

    <header class="pt-10 flex justify-center z-10 relative">
      <AppLogoLight class="h-16 w-auto max-w-[70%] sm:max-w-none"/>
    </header>

    <main class="flex flex-1 items-center justify-center px-4 sm:px-10 z-10 relative text-center">
      <div class="flex flex-col items-center space-y-6 max-w-3xl">
        <h1 class="text-3xl sm:text-5xl font-extrabold leading-snug sm:leading-tight">
          Take control of your finances like a pro.
        </h1>

        <p class="text-sm sm:text-base text-gray-100 max-w-lg sm:max-w-2xl">
          Join hundreds of users who track spending, plan budgets, and achieve financial goals — all in one smart
          system. Your personal hub for managing money with clarity and confidence.
        </p>
      </div>
    </main>

    <footer class="py-6 text-sm sm:text-base">
      <div class="flex justify-center items-center text-center px-4">
        <span class="text-xl">©</span>&nbsp;{{ new Date().getFullYear() }} Money Montana - All rights reserved.
      </div>
    </footer>
  </div>
</template>

<style scoped>
@keyframes fall {
  0% {
    transform: translateY(-4rem) rotate(0deg);
    opacity: var(--opacity);
  }
  100% {
    transform: translateY(calc(100vh + 4rem)) rotate(360deg);
    opacity: 0;
  }
}

.falling-icon {
  position: absolute;
  top: -4rem;
  left: var(--left);
  font-size: var(--size);
  opacity: 0;
  pointer-events: none;
  user-select: none;
  z-index: 1;
}

.falling-icon.animate {
  opacity: var(--opacity);
  animation: fall var(--duration) linear infinite;
  animation-delay: var(--delay);
}

.fall-enter-active,
.fall-leave-active {
  transition: opacity 0.5s;
}

.fall-enter-from,
.fall-leave-to {
  opacity: 0;
}
</style>