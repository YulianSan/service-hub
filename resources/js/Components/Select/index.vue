<script setup lang="ts" generic="T extends { value: string | number, label: string }">
import { computed } from 'vue'

const modelValue = defineModel()

const props = defineProps<{
    id: string,
    options?: T[]
    placeholder?: string,
    labelSelect?: string,
    value: (option: T) => string | number,
    label: (option: T) => string
}>()

const hasOptions = computed(() => props.options && props.options.length)
</script>

<template>
    <label v-if="labelSelect" :for="props.id" class="mb-1 font-medium text-gray-700">
        {{ labelSelect }}
    </label>
    <select :id="props.id" v-model="modelValue" v-bind="$attrs" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm
               focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400
               disabled:bg-gray-100">
        <option v-if="placeholder" value="">
            {{ placeholder }}
        </option>

        <template v-if="hasOptions">
            <option v-for="option in options" :key="value(option)" :value="value(option)">
                {{ label(option) }}
            </option>
        </template>

        <slot />
    </select>
</template>
