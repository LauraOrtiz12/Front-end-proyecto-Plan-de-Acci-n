<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref } from "vue";

const IMAGES = [
    "assets/images/login-background.webp",
    "assets/images/login-background-1.webp",
];

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

let showPassword = ref(false);

function toggleShowPassword() {
    showPassword.value = !showPassword.value;
}

const selectedImage = IMAGES[Math.floor(Math.random() * IMAGES.length)];
</script>

<template>
    <Head title="Ingreso" />

    <main
        class="bg-no-repeat bg-cover bg-center grid grid-cols-2 w-screen h-screen"
    >
        <section
            class="bg-secondary h-full p-6 flex flex-col gap-4 justify-center items-center z-10"
        >
            <span
                class="flex text-white w-full items-center gap-[12px] justify-center"
                ><h1 class="bg-tertiary p-2 rounded-lg">Bienvenido al</h1>PLan Anual De Adquisición</span
            >
            <div class="p-4 w-[31.25rem] rounded-lg">
                <div
                    v-if="status"
                    class="mb-4 font-medium text-sm text-green-600"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <i
                            class="fa-solid fa-envelope absolute translate-x-[0.625rem] translate-y-[2.625rem] text-secondary"
                        ></i>
                        <InputLabel
                            for="email"
                            value="Correo Electrónico"
                            class="text-white"
                        />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            class="mt-1 block w-full pl-8 pr-10"
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <i
                            class="fa-solid fa-key absolute translate-x-[0.625rem] translate-y-[2.625rem] text-secondary"
                        ></i>
                        <InputLabel
                            for="password"
                            value="Contraseña"
                            class="text-white"
                        />
                        <TextInput
                            id="password"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            class="mt-1 block w-full pl-8 pr-10"
                            required
                            autocomplete="current-password"
                        />
                        <i
                            class="fa-solid absolute cursor-pointer hover:bg-gray-200 p-1 rounded-full text-secondary translate-x-[27.1rem] translate-y-[-1.97rem]"
                            :class="showPassword ? 'fa-eye' : 'fa-eye-slash'"
                            @click="toggleShowPassword"
                        >
                        </i>
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox
                                v-model:checked="form.remember"
                                name="remember"
                            />
                            <span class="ms-1 text-[16px] text-white"
                                >Recordarme</span
                            >
                        </label>
                    </div>

                    <div class="flex justify-end flex-col gap-2">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="underline text-[16px] text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Perdí mi contraseña?
                        </Link>

                        <PrimaryButton
                            class="w-full justify-center"
                            :class="{ '': form.processing }"
                            :disabled="form.processing"
                        >
                            Iniciar Sesión
                        </PrimaryButton>
                    </div>
                </form>
            </div>

            <img src="assets/images/logosena.webp" alt="" />
        </section>
        <svg class="absolute rotate-90 w-[100vh] top-[38.9%] left-[29.1%] fill-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path  fill-opacity="1" d="M0,228L80,234.3C160,241,320,253,480,234.3C640,215,800,165,960,126.7C1120,89,1280,63,1440,76C1600,89,1760,139,1920,177.3C2080,215,2240,241,2400,234.3C2560,228,2720,190,2880,196.3C3040,203,3200,253,3360,228C3520,203,3680,101,3840,69.7C4000,38,4160,76,4320,76C4480,76,4640,38,4800,50.7C4960,63,5120,127,5280,145.7C5440,165,5600,139,5760,139.3C5920,139,6080,165,6240,183.7C6400,203,6560,215,6720,202.7C6880,190,7040,152,7200,114C7360,76,7520,38,7680,50.7C7840,63,8000,127,8160,133C8320,139,8480,89,8640,63.3C8800,38,8960,38,9120,82.3C9280,127,9440,215,9600,253.3C9760,291,9920,279,10080,285C10240,291,10400,317,10560,278.7C10720,241,10880,139,11040,82.3C11200,25,11360,13,11440,6.3L11520,0L11520,380L11440,380C11360,380,11200,380,11040,380C10880,380,10720,380,10560,380C10400,380,10240,380,10080,380C9920,380,9760,380,9600,380C9440,380,9280,380,9120,380C8960,380,8800,380,8640,380C8480,380,8320,380,8160,380C8000,380,7840,380,7680,380C7520,380,7360,380,7200,380C7040,380,6880,380,6720,380C6560,380,6400,380,6240,380C6080,380,5920,380,5760,380C5600,380,5440,380,5280,380C5120,380,4960,380,4800,380C4640,380,4480,380,4320,380C4160,380,4000,380,3840,380C3680,380,3520,380,3360,380C3200,380,3040,380,2880,380C2720,380,2560,380,2400,380C2240,380,2080,380,1920,380C1760,380,1600,380,1440,380C1280,380,1120,380,960,380C800,380,640,380,480,380C320,380,160,380,80,380L0,380Z"></path></svg>
        <section
            class="bg-[url('assets/images/login-background-overlay.webp')] bg-cover bg-center h-full overflow-hidden relative *:hover:scale-125"
        >
            <img
                :src="selectedImage"
                alt=""
                class="absolute -z-10 w-full h-full object-cover transition-all duration-1000"
            />
        </section>
    </main>
</template>
