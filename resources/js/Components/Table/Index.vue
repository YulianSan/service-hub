<script setup lang="ts">
import { computed } from 'vue'

interface Column {
    key: string
    label: string
}

const props = defineProps<{
    columns?: Column[]
    data: Record<string, any>[]
}>()

const computedColumns = computed(() => {
    if (props.columns && props.columns.length) {
        return props.columns
    }

    if (!props.data.length) {
        return []
    }

    return Object.keys(props.data[0]).map((key) => ({
        key,
        label: key.charAt(0).toUpperCase() + key.slice(1),
    }))
})
</script>

<template>
    <div class="overflow-x-auto rounded-lg border border-orange-200">
        <table class="min-w-full divide-y divide-orange-200">
            <thead class="bg-orange-50">
                <tr>
                    <th v-for="column in computedColumns" :key="column.key"
                        class="px-4 py-3 text-left text-sm font-semibold text-orange-700">
                        {{ column.label }}
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-orange-100 bg-white">
                <tr v-for="(row, index) in data" :key="index" class="hover:bg-orange-50 transition">
                    <td v-for="column in computedColumns" :key="column.key" class="px-4 py-3 text-sm text-gray-700">
                        <slot :name="`cell(${column.key})`" :row="row" :value="row[column.key]">
                            {{ row[column.key] }}
                        </slot>
                    </td>
                </tr>

                <tr v-if="!data.length">
                    <td :colspan="computedColumns.length" class="px-4 py-6 text-center text-sm text-gray-500">
                        No records found.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
