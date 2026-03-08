<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layout/Authenticated.vue';

</script>
<template>
    <Head title="Welcome"></Head>
    <AuthenticatedLayout>
        Welcome
    </AuthenticatedLayout>
</template>
