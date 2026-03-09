<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layout/Authenticated.vue';
import type { Ticket } from '@/types/ticket';

const props = defineProps<{
    tickets: { data: Ticket[] }
}>()
</script>
<template>
    <AuthenticatedLayout>
        <div class="flex justify-between align-items-center flex-row">
            <Title>Tickets</Title>
            <Link :href="$route('tickets.create')">
            <ButtonPrimary> Create Tickets </ButtonPrimary>
            </Link>
        </div>
        <div class="mt-4">
            <Table :columns="[
                { key: 'id', label: 'ID' },
                { key: 'title', label: 'Title' },
                { key: 'status', label: 'Status' },
                { key: 'project', label: 'Project' },
                { key: 'actions', label: '' },
            ]" :data="props.tickets.data">
                <template #cell(project)="{ value }">
                    {{ value.name }}
                </template>
                <template #cell(actions)="{ row }">
                    <Link :href="$route('tickets.edit', row.id)">
                    <ButtonSecondary> Edit </ButtonSecondary>
                    </Link>
                    <Link :href="$route('tickets.destroy', row.id)" method="delete">
                    <ButtonDanger> Delete </ButtonDanger>
                    </Link>
                </template>
            </Table>
        </div>
    </AuthenticatedLayout>
</template>
