<script setup lang="ts">
import AuthenticatedLayout from '@/Layout/Authenticated.vue';
import { useForm, router } from '@inertiajs/vue3';
import { route } from '@/services/route'
import type { Project } from '@/types/project';

const props = defineProps<{
    project?: Project
}>()

const form = useForm({
    name: props.project?.name ?? '',
    description: props.project?.description ?? '',
})

const submit = () => {
    if (props.project) {
        form.put(route('projects.update', props.project.id))
        return
    }
    form.post(route('projects.store'))
}

const cancel = () => {
    router.visit(route('projects.index'))
}

</script>
<template>
    <AuthenticatedLayout>
        <Form @submit="submit" @cancel="cancel" title="Create Project">
            <Input id="name" v-model="form.name"> Name </Input>
            <InputTextarea id="description" rows="10" v-model="form.description"> Description </InputTextarea>
        </Form>
    </AuthenticatedLayout>
</template>
