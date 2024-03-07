<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm, Head } from "@inertiajs/vue3";

defineProps(["group_id"]);

const form = useForm({
    title: "",
    text_content: "",
});
</script>

<template>
    <Head title="New Post" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form
                @submit.prevent="
                    form.post(route('community_group.post.store', {
                        community_group: group_id
                    }), {
                        onSuccess: () => form.reset(),
                    })
                "
            >
                <input
                    v-model="form.title"
                    placeholder="Post title?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <InputError :message="form.errors.title" class="mt-2" />
                <textarea v-model="form.text_content" placeholder="Post content" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <InputError :message="form.errors.text_content" class="mt-2" />
                <PrimaryButton class="mt-4">Submit</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
