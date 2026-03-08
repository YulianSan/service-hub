<script setup lang="ts">
import { provide, computed } from 'vue';

const props = defineProps<{
    title: string
    errors?: Record<string, string[]>
}>()

const emit = defineEmits(['submit', 'cancel'])

provide('errors', computed(() => props.errors))

</script>
<template>
    <Box>
        <Title>{{ props.title }}</Title>
        <form @submit.prevent="emit('submit')">
            <slot />
            <div class="flex justify-end mt-4 gap-2">
                <slot name="actions">
                    <ButtonPrimary type="submit"> Confirm </ButtonPrimary>
                    <ButtonSecondary type="button" @click="$emit('cancel')"> Cancel </ButtonSecondary>
                </slot>
            </div>
        </form>
    </Box>
</template>
