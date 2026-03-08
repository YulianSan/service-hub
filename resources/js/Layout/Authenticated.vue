<script setup lang="ts">
import { Link, usePage, useForm } from '@inertiajs/vue3';
import { route } from '@/services/route'
const page = usePage();

const form = useForm({});

const markAsRead = (id: number) => {
    form.post(route('notifications.read', id));
}
</script>
<template>
    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                <div class="text-xl font-bold text-orange-500">ServiceHub</div>

                <nav class="flex space-x-4">
                    <Link :href="$route('home')">Dashboard</Link>
                    <Link :href="$route('tickets.index')">Tickets</Link>
                    <Link :href="$route('projects.index')">Projects</Link>
                </nav>

                <div>
                    <ButtonNotification :notifications="page.props.notifications" @click="markAsRead" />
                    <ButtonProfile :user="page.props.auth.user" />
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto p-4">
            <slot />
        </main>
    </div>
</template>
