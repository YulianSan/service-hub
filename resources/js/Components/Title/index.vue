<template>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            <slot />
        </h1>

        <p v-if="$slots.subtitle" class="text-sm text-gray-500 mt-1">
            <slot name="subtitle" />
        </p>
    </div>
</template>
