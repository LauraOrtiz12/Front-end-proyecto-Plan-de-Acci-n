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
  'assets/images/login-background.webp',
  'assets/images/login-background-1.webp',
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
</script>

<template>
  <Head title="Ingreso" />

  <main class="bg-no-repeat bg-cover bg-center grid grid-cols-2 w-screen h-screen">
    <section class=""></section>
    <section class="bg-[url('assets/images/login-background-overlay.webp')] bg-cover bg-center h-full">
      <img :src="IMAGES[Math.floor(Math.random() * IMAGES.length)]" alt="" class="absolute -z-10 w-1/2 h-full object-cover">
    </section>
  </main>
</template>