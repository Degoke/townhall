<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";
import Post from "@/Components/Post.vue";
import { Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { useForm } from '@inertiajs/vue3';

defineProps(["memberships", "group", "community", "membership"]);
</script>

<template>
    <Head title="Community" />

    <AuthenticatedLayout :memberships="memberships" :community="community">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <NavLink
                        :href="route('community.new')"
                        :active="route().current('community.new')"
                    >
                        Messages
                    </NavLink>
                    <!-- <NavLink
                        :href="route('community.new')"
                        :active="route().current('community.new')"
                    >
                        Calls
                    </NavLink>
                    <NavLink
                        :href="route('community.new')"
                        :active="route().current('community.new')"
                    >
                        Payments
                    </NavLink>
                    <NavLink
                        :href="route('community.new')"
                        :active="route().current('community.new')"
                    >
                        Polls
                    </NavLink> -->
                    <NavLink
                    v-if="$page.props.membership.is_admin"
                        :href="route('community.show', {
                            community: community.id
                        })"
                        :active="route().current('community.show')"
                    >
                        Settings
                    </NavLink>
                </div>
            </div>
        </nav>
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <div v-if="community">
                        <NavLink
                        v-for="group in community.community_groups"
                        :key="group.id"
                        :href="
                            route('dashboard', {
                                community_id: community.id,
                                group_id: group.id
                            })
                        "
                        :active="
                            route().current('dashboard', {
                                community_id: community.id,
                                group_id: group.id,
                            })
                        "
                    >
                        {{ group.name }}
                    </NavLink>
                    </div>
                </div>
            </div>
        </nav>
        <main>
            <div v-if="group">
                        <div v-if="$page.props.membership.is_admin">
                            <NavLink
                        :href="route('post.new', {
                            group_id: group.id
                        })"
                        :active="route().current('post.new')"
                    >
                        <PrimaryButton class="mt-4"
                            >New Post</PrimaryButton
                        >
                    </NavLink>
                        </div>
            </div>
            <div v-if="group">
                <Post v-for="post in group.posts"
                        :key="post.id"
                        :post="post" />
            </div>
        </main>
    </AuthenticatedLayout>
</template>
