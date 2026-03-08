<script setup lang="ts">
import AuthenticatedLayout from '@/Layout/Authenticated.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    projects: { data: Record<string, any>[] }
}>()
</script>
<template>
    <AuthenticatedLayout>
        <div class="flex justify-between align-items-center flex-row">
            <Title>Projects</Title>
            <Link :href="$route('projects.create')">
            <ButtonPrimary> Create Project </ButtonPrimary>
            </Link>
        </div>
        <div class="mt-4">
            <Table :columns="[
                { key: 'id', label: 'ID' },
                { key: 'name', label: 'Name' },
                { key: 'description', label: 'Description' },
                { key: 'actions', label: '' },
            ]" :data="props.projects.data">
                <template #cell(actions)="{ row }">
                    <Link :href="$route('projects.edit', row.id)">
                    <ButtonSecondary> Edit </ButtonSecondary>
                    </Link>
                    <Link :href="$route('projects.destroy', row.id)" method="delete">
                    <ButtonDanger> Delete </ButtonDanger>
                    </Link>
                </template>
            </Table>
        </div>
    </AuthenticatedLayout>
</template>
