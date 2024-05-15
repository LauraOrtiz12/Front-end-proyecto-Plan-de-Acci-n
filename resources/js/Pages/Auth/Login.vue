<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

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

const selectedImage = IMAGES[Math.floor(Math.random() * IMAGES.length)];
</script>

<template>
    <Head title="Ingreso" />

    <main class="bg-no-repeat bg-cover bg-center grid grid-cols-2 w-screen h-screen">
        <section class="bg-[#04324d] h-full p-6 flex flex-col gap-4 justify-center items-center">
            <!-- <h1 class="bg-[#FFA900]  p-2 rounded-lg">Bienvenido a <span>Lorem ipsum dolor</span></h1> -->
                    <div class="bg-[#e6e6e6] p-4 w-[31.25rem] rounded-lg ">
                        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                            {{ status }}
                        </div>
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="email" value="Correo Electrónico" />
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    class="mt-1 block w-full"
                                    autofocus
                                    autocomplete="username"
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-4 ">
                                <InputLabel for="password" value="Clave" />
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="current-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div class="block mt-4">
                                <label class="flex items-center">
                                    <Checkbox v-model:checked="form.remember" name="remember" />
                                    <span class="ms-1 text-[16px] text-[#39a900]">Recordarme</span>
                                </label>
                            </div>

                            <div class="flex justify-start flex-col gap-2">
                                <Link v-if="canResetPassword" :href="route('password.request')" class=" underline text-[16px] text-[#39a900] hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Perdí mi contraseña?
                                </Link>

                                <PrimaryButton class="w-full justify-center " :class="{ '': form.processing }" :disabled="form.processing">
                                Iniciar Sesión
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
            <div class="">
                <img src="assets/images/logosena.webp" alt="">
            </div>
        </section>
        
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