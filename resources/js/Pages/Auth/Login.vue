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

    <main class="bg-no-repeat bg-cover bg-center grid grid-cols-2 w-screen h-screen">
        <section class="bg-secondary h-full p-6 flex flex-col  gap-[20px] justify-center  items-center z-10">
            <div class="flex flex-col items-center leading-[25px]">
            <h1 style="font-size: 25px; "class="font-extrabold text-white p-2 rounded-lg">Bienvenido al</h1>
            <span style="font-size: 25px ;" class="font-bold  text-primary flex text-white w-full items-center  justify-center">
                Plan Anual De Adquisición
            </span>
            </div>
            <div class="gap-[5px] p-4 w-[31.25rem] rounded-lg">
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <i
                            class="fa-solid fa-envelope absolute translate-x-[0.625rem] translate-y-[2.625rem] text-secondary"></i>
                        <InputLabel for="email" value="Correo Electrónico" class="text-white" />
                        <TextInput id="email" v-model="form.email" type="email" required
                            class="mt-1 block w-full pl-8 pr-10" autofocus autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <i
                            class="fa-solid fa-key absolute translate-x-[0.625rem] translate-y-[2.625rem] text-secondary"></i>
                        <InputLabel for="password" value="Contraseña" class="text-white" />
                        <TextInput id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'"
                            class="mt-1 block w-full pl-8 pr-10" required autocomplete="current-password" />
                        <i class="fa-solid absolute cursor-pointer hover:bg-gray-200 p-1 rounded-full text-secondary translate-x-[27.1rem] translate-y-[-1.97rem]"
                            :class="showPassword ? 'fa-eye' : 'fa-eye-slash'" @click="toggleShowPassword">
                        </i>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="block mt-4">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="form.remember" name="remember" />
                            <span class="ms-1 text-[16px] text-white">Recordarme</span>
                        </label>
                    </div>

                    <div class="flex justify-end flex-col gap-2">
                        <Link v-if="canResetPassword" :href="route('password.request')"
                            class="underline text-[16px] text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Perdí mi contraseña?
                        </Link>

                        <PrimaryButton class="w-full justify-center" :class="{ '': form.processing }"
                            :disabled="form.processing">
                            Iniciar Sesión
                        </PrimaryButton>
                    </div>
                </form>
            </div>

            <img src="assets/images/logosena.webp" alt="" />
        </section>

        <section
            class="bg-[url('assets/images/login-background-overlay.webp')] bg-cover bg-center h-full overflow-hidden relative *:hover:scale-125">
            <img :src="selectedImage" alt=""
                class="absolute -z-10 w-full h-full object-cover transition-all duration-1000" />
        </section>
    </main>
</template>
