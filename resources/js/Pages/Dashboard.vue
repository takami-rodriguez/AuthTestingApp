<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import {Table} from "@protonemedia/inertiajs-tables-laravel-query-builder";


const submit = (userid) => {

    this.$inertia.post(route('users.impersonate', {user: userid}), {
        onFinish: () => {
        }
    })
};
defineProps(["users"])
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hello!
            </h2>
        </template>

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        This is your dashboard {{ $page.props.auth.user.name }}!<br/>
                        You have  <span :class="[$page.props.auth.user.admin ? ['text-red-600 font-bold','text-basefont-bold'] : ''] "> {{$page.props.auth.user.admin ? 'Admin' : 'normal user'}}</span> privileges
                    </div>
                    <div v-if="$page.props.is_impersonating" class="p-12">
                        You are impersonating!<br/>

                        <a href="/leave-impersonate"
                           class="text-red-400 hover:text-red-400"
                        >Relog with your original account</a>
                    </div>
                    <div v-if="$page.props.auth.user.admin" class="p-12">
                        <div>
                            <span class="text-red-600 font-bold"> Only administrators can see this table!</span>
                        </div>

                        <Table :meta="users" class="min-w-full divide-y divide-gray-300 ">
                            <template #head >
                                <tr class="bg-spark-blue">
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-white">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold  text-white">
                                        Name
                                    </th>

                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                        Email
                                    </th>

                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                                        Created at
                                    </th>


                                </tr>
                            </template>
                            <template #body class="divide-y divide-gray-200 bg-white">
                                <tr
                                    v-for="(user, key) in users.data"
                                    :key="key"
                                >
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-left text-sm font-medium sm:pr-6">
                                        <a :href="`/${user.id}/impersonate`"
                                           class="text-indigo-600 hover:text-indigo-900"
                                        >Log as user<span class="sr-only">Enter</span></a
                                        >


                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 font-semibold">
                                        {{ user.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ user.email }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{
                                            user.created_at
                                        }}
                                    </td>

                                </tr>
                            </template>
                        </Table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
