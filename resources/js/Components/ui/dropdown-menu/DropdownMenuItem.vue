<script setup lang="ts">
import type { DropdownMenuItemProps } from "reka-ui"
import type { HTMLAttributes } from "vue"
import { reactiveOmit } from "@vueuse/core"
import { DropdownMenuItem, useForwardProps } from "reka-ui"
import { cn } from "@/lib/utils"

const props = withDefaults(defineProps<DropdownMenuItemProps & {
    class?: HTMLAttributes["class"]
    inset?: boolean
    variant?: "default" | "destructive"
}>(), {
    variant: "default",
})

const delegatedProps = reactiveOmit(props, "inset", "variant", "class")

const forwardedProps = useForwardProps(delegatedProps)
</script>

<template>
    <DropdownMenuItem data-slot="dropdown-menu-item" :data-inset="inset ? '' : undefined" :data-variant="variant"
        v-bind="forwardedProps"
        :class="cn('relative flex cursor-default items-center gap-2 rounded px-2 py-1.5 text-sm select-none outline-none',
            'focus:bg-orange-100 focus:text-orange-700 focus:ring-2 focus:ring-orange-400',
            'data-[variant=destructive]:text-red-600 data-[variant=destructive]:focus:bg-red-100 data-[variant=destructive]:focus:text-red-700',
            'data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
            'data-[inset]:pl-8 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=\'size-\'])]:size-4', props.class)">
        <slot />
    </DropdownMenuItem>
</template>
