<script setup lang="ts">
import { defineProps } from 'vue'

defineProps<{
    class?: string
}>()
</script>

<template>
    <Box :class="[
        ' max-w-md',
        $props.class
    ]">
        <slot />
    </Box>
</template>
