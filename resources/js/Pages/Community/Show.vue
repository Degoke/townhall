<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head } from '@inertiajs/vue3';

defineProps([
    'community',
    'invite_link'
]);
</script>

<template>
    <Head title="Community" />

    <AuthenticatedLayout :community="community">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Community</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <header>
            <h2 class="text-lg font-medium text-gray-900">Invite Link</h2>

            <p class="mt-1 text-sm text-gray-600">
               Share this link to invite members to your community.
            </p>
            <p class="mt-1 text-sm text-gray-600">
               {{ invite_link }}
            </p>
        </header>

        <PrimaryButton>Copy</PrimaryButton>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
