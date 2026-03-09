<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layout/Authenticated.vue';
import { route } from '@/services/route'
import type { Project } from '@/types/project';
import type { Ticket } from '@/types/ticket';

const props = defineProps<{
    ticket?: Ticket,
    projects: Project[]
}>()

const form = useForm({
    project_id: props.ticket?.project_id ?? '',
    title: props.ticket?.title ?? '',
    attachment: null
})

const submit = () => {
    if (props.ticket) {
        form.put(route('tickets.update', props.ticket.id))
        return
    }
    form.post(route('tickets.store'))
}

const cancel = () => {
    router.visit(route('tickets.index'))
}

const metadata = computed(() => {
    return JSON.stringify(props.ticket?.details?.metadata)
})

const editable = computed(() => {
    return !!props?.ticket?.id
})
</script>
<template>
    <AuthenticatedLayout>
        <Form @submit="submit" @cancel="cancel" :title="editable ? `Edit ticket` : `Create ticket`"
            :errors="$page.props.errors">
            <Input id="title" v-model="form.title"> Title </Input>
            <Select id="project_id" v-model="form.project_id" :options="props.projects" :label="(option) => option.name"
                :value="(option) => option.id" labelSelect="Project" />
            <InputFile v-if="props?.ticket?.status !== 'closed'" id="attachment" v-model="form.attachment"
                accept=".txt,.json"> Attachment </InputFile>
            <template v-if="!!props?.ticket?.id && !!props.ticket.details">
                <Title class="mt-5">Details</Title>
                <Input id="errors" :value="props.ticket.details.errors" disabled> Errors </Input>
                <Input id="technical_notes" :value="props.ticket.details.technical_notes" disabled> Technical Notes
                </Input>
                <InputTextarea id="metadata" :value="metadata" disabled> Metadata </InputTextarea>
            </template>
            <template v-if="!!props?.ticket?.id && !props?.ticket?.details">
                <p class="px-4 py-6 text-sm text-gray-500 mt-5">
                    Ticket without details
                </p>
            </template>
        </Form>
    </AuthenticatedLayout>
</template>
