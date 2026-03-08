<script setup lang="ts">
import AuthenticatedLayout from '@/Layout/Authenticated.vue';
import { useForm, router } from '@inertiajs/vue3';
import { route } from '@/services/route'
import type { User } from '@/types/user';

const props = defineProps<{
    user?: User
}>()

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user?.profile?.phone ?? '',
})

const submit = () => {
    form.put(route('users-profile.update', props.user.id))
}

const cancel = () => {
    router.visit(route('home'))
}

</script>
<template>
    <AuthenticatedLayout>
        <Form @submit="submit" @cancel="cancel" title="User Profile" :errors="$page.props.errors">
            <Input id="name" v-model="form.name"> Name </Input>
            <Input id="email" type="email" v-model="form.email"> Email </Input>
            <Input id="phone" v-model="form.phone"> Phone </Input>
        </Form>
    </AuthenticatedLayout>
</template>
