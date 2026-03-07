<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <Link v-bind="$attrs" class="text-gray-700 hover:text-orange-500 transition-colors font-medium">
        <slot />
    </Link>
</template>
