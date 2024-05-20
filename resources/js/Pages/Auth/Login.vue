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

    <main class=" bg-secondary bg-no-repeat bg-cover bg-center grid xl:grid-cols-2 w-screen h-screen">
        <section class="p-6 flex flex-col gap-5 justify-center items-center">
            <div class="text-center leading-6">
                <h1 class="font-extrabold text-2xl text-white">Bienvenido al</h1>
                <span class="font-bold text-2xl text-primary">
                    Plan Anual De Adquisición
                </span>
            </div>
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-2 w-full max-w-md">
                <div>
                    <i class="fa-solid fa-envelope absolute translate-x-[62.5%] translate-y-[260%] text-secondary"></i>
                    <InputLabel for="email" value="Correo Electrónico" class="text-white" />
                    <TextInput id="email" v-model="form.email" type="email" required
                        class="mt-1 block w-full pl-8 pr-10" autofocus autocomplete="username" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="flex flex-col">
                    <i class="fa-solid fa-key absolute translate-x-[62.5%] translate-y-[260%] text-secondary"></i>
                    <InputLabel for="password" value="Contraseña" class="text-white" />
                    <TextInput id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'"
                        class="mt-1 block w-full pl-8 pr-10" required autocomplete="current-password" />
                    <i class="fa-solid cursor-pointer relative self-end hover:bg-gray-200 p-1 rounded-full text-secondary bottom-8 right-2"
                        :class="showPassword ? 'fa-eye' : 'fa-eye-slash'" @click="toggleShowPassword">
                    </i>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />

                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ms-1 text-[16px] text-white">Recordarme</span>
                </label>

                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="underline text-[16px] text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Perdí mi contraseña?
                </Link>

                <PrimaryButton class="w-full justify-center" :class="{ '': form.processing }"
                    :disabled="form.processing">
                    Iniciar Sesión
                </PrimaryButton>
            </form>

            <img src="assets/images/logosena.webp" alt="" />
        </section>

        <section class="background-hover overflow-hidden rounded-bl-[50%] row-start-1 xl:row-start-auto">
            <img src="assets/images/login-background-overlay.webp" alt=""
                class="object-cover transition-all duration-1000 relative z-10 w-full h-full" />
            <img :src="selectedImage" alt=""
                class="object-cover order-1 transition-all duration-1000 relative -translate-y-full w-full h-full" />
        </section>
    </main>
</template>

<style>
.background-hover:hover> :nth-child(2) {
    --tw-scale-x: 1.25;
    --tw-scale-y: 1.25;
    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
}
</style>
