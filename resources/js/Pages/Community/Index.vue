<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Community from '@/Components/Commuity.vue';
import { useForm, Head } from '@inertiajs/vue3';

defineProps(['communities']);

const form = useForm({
    name: '',
});
</script>

<template>
<Head title="Community" />

<AuthenticatedLayout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('community.store'), { onSuccess: () => form.reset() })">
                <input
                    v-model="form.name"
                    placeholder="Community name?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <InputError :message="form.errors.name" class="mt-2" />
                <PrimaryButton class="mt-4">Submit</PrimaryButton>
            </form>

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Community
                    v-for="community in communities"
                    :key="community.id"
                    :community="community"
                />
            </div>
        </div>
</AuthenticatedLayout>
</template>