<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm, Head } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    description: "",
});
</script>

<template>
    <Head title="New Community" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form
                @submit.prevent="
                    form.post(route('community.store'), {
                        onSuccess: () => form.reset(),
                    })
                "
            >
                <input
                    v-model="form.name"
                    placeholder="Community name?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <InputError :message="form.errors.name" class="mt-2" />
                <input
                    v-model="form.description"
                    placeholder="Community description?"
                    class="block w-full mt-4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <InputError :message="form.errors.description" class="mt-2" />
                <PrimaryButton class="mt-4">Submit</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
