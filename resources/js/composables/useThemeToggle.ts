import {computed, onMounted, ref, watch} from 'vue';
import {getCurrentTheme, switchTheme} from '@/Load/darkMode';

export function useThemeToggle() {
    const isDark = ref(false);

    onMounted(() => {
        isDark.value = getCurrentTheme() === 'dark';
    });

    const isLightToggle = computed({
        get: () => !isDark.value,
        set: (val: boolean) => {
            isDark.value = !val;
        }
    });

    const toggleByTheme = (theme: string) => {
        isDark.value = theme === 'dark';
        switchTheme(isDark.value);
    }

    const toggleDark = () => {
        isDark.value = !isDark.value;
    }

    watch(isDark, (newVal) => {
        switchTheme(newVal);
    });

    return {
        isDark,
        isLightToggle,
        toggleDark,
        toggleByTheme
    };
}
