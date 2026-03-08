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
                    <UiPopoverPopover>
                        <UiPopoverPopoverTrigger as-child>
                            <ButtonPrimary>
                                🔔({{ page.props.notifications?.length ?? 0 }})
                            </ButtonPrimary>
                        </UiPopoverPopoverTrigger>

                        <UiPopoverPopoverContent
                            class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-md shadow-lg max-h-96 overflow-y-auto z-50">
                            <div v-for="notification in page.props.notifications" :key="notification.id"
                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex justify-between items-center"
                                @click="markAsRead(notification.id)">
                                <span :class="{ 'font-bold': !notification.read_at }">{{ notification.data.message
                                    }}</span>
                                <span v-if="!notification.read_at" class="w-2 h-2 bg-red-500 rounded-full"></span>
                            </div>
                            <div v-if="page.props.notifications.length === 0" class="px-4 py-2 text-gray-400 text-sm">
                                Sem notificações
                            </div>
                        </UiPopoverPopoverContent>
                    </UiPopoverPopover>
                    <Link href="/logout" method="post" as="span">
                    <ButtonSecondary>
                        Logout
                    </ButtonSecondary>
                    </Link>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto p-4">
            <slot />
        </main>
    </div>
</template>
