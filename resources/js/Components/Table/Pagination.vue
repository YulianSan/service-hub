<script setup lang="ts">
import { markRaw } from 'vue'
import { Link } from '@inertiajs/vue3'
import type { Pagination } from '@/types/pagination'

defineProps<{
    pagination: Pagination<null>
}>()

const InertiaLink = markRaw(Link)
</script>

<template>
    <UiPaginationPagination v-if="pagination.links.length > 3" :items-per-page="pagination.per_page"
        :total="pagination.total" :page="pagination.current_page">
        <UiPaginationPaginationContent>
            <UiPaginationPaginationPrevious :as="InertiaLink" :href="pagination.links[0].url ?? '#'" />

            <template v-for="link in pagination.links.slice(1, -1)">
                <UiPaginationPaginationItem v-if="!!link.url" :value="link.page" :as="InertiaLink" :href="link.url" :is-active="link.active">
                    {{ link.label }}
                </UiPaginationPaginationItem>
                <span v-else class="px-3 py-2 text-muted-foreground">
                    ...
                </span>
            </template>

            <UiPaginationPaginationNext :as="InertiaLink" :href="pagination.links[pagination.links.length - 1].url || '#'" />

        </UiPaginationPaginationContent>
    </UiPaginationPagination>
</template>
