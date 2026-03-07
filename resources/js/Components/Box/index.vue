<script setup lang="ts">
import { defineProps } from 'vue'

defineProps<{
    class?: string
}>()
</script>

<template>
    <div :class="[
        'bg-white rounded-lg border border-orange-400 shadow-md shadow-orange-100 p-6 w-full max-w-md mx-auto',
        $props.class
    ]">
        <slot />
    </div>
</template>
