<script setup lang="ts">
import { defineProps, watch, onMounted } from 'vue';

const modelValue = defineModel();
const props = defineProps<{
    id: string
    error?: string
    value?: string
}>();

watch(() => props.value, (newVal) => {
    if (newVal !== undefined && newVal !== modelValue.value) {
        modelValue.value = newVal
    }
})

onMounted(() => {
    if (props.value) {
        modelValue.value = props.value
    }
})
</script>

<template>
    <div class="mb-4">
        <label v-if="$slots.default" class="block mb-1 font-medium text-gray-700">
            <slot />
        </label>
        <textarea v-bind="$attrs" v-model="modelValue" :id="props.id"
            class="w-full rounded-md border border-gray-300 focus:outline-none focus:ring focus:ring-orange-400 focus:border-orange-400 p-2 transition-colors duration-150 resize-none" />
        <p v-if="props.error" class="mt-1 text-sm text-red-500">{{ props.error }}</p>
    </div>
</template>
