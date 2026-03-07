<script setup lang="ts">
const modelValue = defineModel()

const props = defineProps<{
    id: string,
    error?: string
}>()
</script>

<template>
    <div class="flex flex-col w-full">
        <label v-if="$slots.default" :for="props.id" class="mb-1 font-medium text-gray-700">
            <slot />
        </label>
        <input v-model="modelValue" :id="props.id" v-bind="$attrs"
            class="px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-colors disabled:bg-gray-100 disabled:text-gray-400" />
        <MessageError v-if="error">{{ error }}</MessageError>
    </div>
</template>
