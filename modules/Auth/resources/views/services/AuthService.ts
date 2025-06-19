import { router } from '@inertiajs/vue3'
import {UserRegisterRequest} from "@Modules/Auth/resources/views/components/Registration/RegisterForm.vue";

export const AuthService = {
    register(data: UserRegisterRequest, onSuccess?: () => void, onError?: (errors: any) => void, onBefore?: () => void) {
        router.post('/register', {
            ...data.user,
            ...data.preferences
        }, {
            preserveState: true,
            preserveScroll: true,
            async: true,
            replace: true,
            onSuccess,
            onError,
            onBefore,
        });
    }
}