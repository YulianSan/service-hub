<script setup lang="ts">
import { inject, computed } from 'vue';
import type { ComputedRef } from 'vue';

const props = defineProps<{
    id?: string
    error?: string
    modelValue?: File | null
}>()

const emit = defineEmits(['update:modelValue'])

const handleFile = (event: Event) => {
    const target = event.target as HTMLInputElement
    const file = target.files?.[0] ?? null

    emit('update:modelValue', file)
}

const errors = inject<ComputedRef<Record<string, string[]>>>('errors')

const error = computed(() => {
    return errors?.value?.[props.id] ?? props?.error
})
</script>

<template>
    <div class="flex flex-col w-full">

        <label v-if="$slots.default" :for="props.id" class="mb-1 font-medium text-gray-700">
            <slot />
        </label>

        <input type="file" :id="props.id" v-bind="$attrs" @change="handleFile" class="px-4 py-2 rounded border border-gray-300
                   focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400
                   transition-colors
                   file:mr-4 file:py-2 file:px-3 file:rounded file:border-0
                   file:bg-orange-500 file:text-white file:cursor-pointer
                   hover:file:bg-orange-600
                   disabled:bg-gray-100 disabled:text-gray-400" />

        <MessageError v-if="error">
            {{ error }}
        </MessageError>

    </div>
</template>
