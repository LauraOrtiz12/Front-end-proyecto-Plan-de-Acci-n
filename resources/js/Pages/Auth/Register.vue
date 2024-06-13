<script setup>
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/buttons.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    code: '',
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    role_id: '',
});

defineProps({
    role: Array
});

const emit = defineEmits(['close'])

const submit = () => {
    form.post(route('newUser'), {
        onFinish: () => {
            emit('close');
        },
    });
};
</script>

<template>
    <AuthenticationCard>
        <form @submit.prevent="submit">
            <div>
                Código Interno: {{form.code}}
                <InputLabel for="code" value="Código"/>
                <TextInput
                    id="code"
                    v-model="form.code"
                    type="text"
                    class="mt-1 block w-full"

                    autofocus
                    autocomplete="code"
                />
                <InputError class="mt-2" :message="form.errors.code"/>
            </div>
            <div>
                <InputLabel for="name" value="Nombre Completo"/>
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name"/>
            </div>
            <div class="mt-4">
                <InputLabel for="email" value="Correo Electronico"/>
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Clave"/>
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar Clave"/>
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation"/>
            </div>
            <div class="mt-4">
                <InputLabel for="rol" value="Rol"/>
                <select name="rol" id="rol" class="w-100" v-model="form.role_id">
                    <option :value="rol.id" v-for="rol in role">
                        {{ rol.rol }}
                    </option>
                </select>

            </div>
            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required/>


                    </div>
                    <InputError class="mt-2" :message="form.errors.terms"/>
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Crear Usuario
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
