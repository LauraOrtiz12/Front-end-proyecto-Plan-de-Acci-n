import { usePage } from '@inertiajs/vue3';
import { form } from './Register.vue';

export const submit = async () => {
const response = await form.post(route('newUser'), {
onFinish: () => form.reset('password', 'password_confirmation'),
});

if (response.ok) {
// Si la respuesta es exitosa, redirecciona al usuario a la página deseada
// Puedes usar usePage() para obtener el objeto de la página actual y utilizar su método push() para redireccionar
const page = usePage();
page.push(route('listUsers'));
}
};
