<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import { Head } from "@inertiajs/vue3";
import { watch } from "vue";

defineProps(["memberships", "groups", "group", "community"]);
</script>

<template>
    <Head title="Community" />

    <AuthenticatedLayout>
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <NavLink
                        v-for="membership in memberships"
                        :key="membership.id"
                        :href="
                            route('community.index', {
                                communityId: membership.community.id,
                            })
                        "
                        :active="
                            route().current('community.index', {
                                communityId: membership.community.id,
                            })
                        "
                    >
                        {{ membership.community.name }}
                    </NavLink>
                    <NavLink
                        :href="route('community.new')"
                        :active="route().current('community.new')"
                    >
                        <PrimaryButton class="mt-4"
                            >New Community</PrimaryButton
                        >
                    </NavLink>
                </div>
            </div>
        </nav>
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <NavLink
                        v-for="group in groups"
                        :key="group.id"
                        :href="
                            route('community.index', {
                                communityId: community.id,
                                groupId: group.id
                            })
                        "
                        :active="
                            route().current('community.index', {
                                communityId: community.id,
                                groupId: group.id,
                            })
                        "
                    >
                        {{ group.name }}
                    </NavLink>
                </div>
            </div>
        </nav>
    </AuthenticatedLayout>
</template>
