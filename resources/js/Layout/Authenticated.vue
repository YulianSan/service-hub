<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                <div class="text-xl font-bold text-orange-500">ServiceHub</div>

                <nav class="flex space-x-4">
                    <Link href="#">Dashboard</Link>
                    <Link href="#">Tickets</Link>
                    <Link href="#">Projects</Link>
                    <Link href="#">Companies</Link>
                </nav>

                <div>
                    <Link href="/logout" method="post" as="span">
                    <ButtonPrimary>
                        Logout
                    </ButtonPrimary>
                    </Link>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto p-4">
            <slot />
        </main>
    </div>
</template>
