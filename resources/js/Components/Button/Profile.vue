<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import type { User } from '@/types/user';

const props = defineProps<{ user: User }>()
</script>
<template>
    <UiDropdownMenuDropdownMenu>
        <UiDropdownMenuDropdownMenuTrigger as-child>
            <ButtonSecondary>
                Profile - {{ props.user.name }}
            </ButtonSecondary>
        </UiDropdownMenuDropdownMenuTrigger>
        <UiDropdownMenuDropdownMenuContent class="w-56" align="start">
            <UiDropdownMenuDropdownMenuGroup>
                <Link :href="$route('users-profile.edit', props.user.id)" as="span">
                <UiDropdownMenuDropdownMenuItem>
                    Profile
                </UiDropdownMenuDropdownMenuItem>
                </Link>
                <Link :href="$route('logout')" method="post" as="span">
                <UiDropdownMenuDropdownMenuItem>
                    Log out
                </UiDropdownMenuDropdownMenuItem>
                </Link>
            </UiDropdownMenuDropdownMenuGroup>
        </UiDropdownMenuDropdownMenuContent>
    </UiDropdownMenuDropdownMenu>
</template>
