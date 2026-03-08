<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3'
import { route } from '@/services/route'

const props = defineProps<{
    notifications: any
}>()

const form = useForm({});

const markAsRead = (notification: any) => {
    form.post(route('notifications.read', notification.id), {
        onSuccess: () => {
            router.visit(route('tickets.edit', notification.data.ticket_id))
        }
    });
}
</script>
<template>
    <UiPopoverPopover>
        <UiPopoverPopoverTrigger as-child>
            <ButtonPrimary>
                🔔({{ props.notifications?.length ?? 0 }})
            </ButtonPrimary>
        </UiPopoverPopoverTrigger>

        <UiPopoverPopoverContent
            class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-md shadow-lg max-h-96 overflow-y-auto z-50">
            <div v-for="notification in props.notifications" :key="notification.id"
                class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex justify-between items-center"
                @click="markAsRead(notification)">
                <span :class="{ 'font-bold': !notification.read_at }">
                    {{ notification.data.ticket_id }} - {{ notification.data.message }}
                </span>
                <span v-if="!notification.read_at" class="w-2 h-2 bg-red-500 rounded-full"></span>
            </div>
            <div v-if="props.notifications.length === 0" class="px-4 py-2 text-gray-400 text-sm">
                No notifications
            </div>
        </UiPopoverPopoverContent>
    </UiPopoverPopover>
</template>
