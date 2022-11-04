<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">

                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Forgot your password?
                </Link>


                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
            <div class="flex items-center justify-center mt-12">
                <Link :href="route('register')" class="underline text-md text-gray-600 hover:text-gray-900">
                    Register new account
                </Link>
            </div>

            <div class="flex items-center justify-center mt-12">

                <table class="min-w-full divide-y divide-gray-300 ">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Email</th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Password</th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">Account Type</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr>
                        <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm text-left font-medium text-gray-900 sm:pl-6">admin@test.com</td>
                        <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm text-left font-medium text-gray-900 sm:pl-6">password</td>
                        <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm font-medium text-left text-gray-900 sm:pl-6">Administrator</td>
                    </tr>
                    <tr>
                        <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm text-left font-medium text-gray-900 sm:pl-6">mclaughlin.crawford@example.org</td>
                        <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm text-left font-medium text-gray-900 sm:pl-6">password</td>
                        <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm font-medium text-left text-gray-900 sm:pl-6">Normal user</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </form>
    </GuestLayout>
</template>
