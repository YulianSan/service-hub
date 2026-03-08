<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';

const page = usePage();

const form = useForm({
    email: '',
    password: ''
})

const submit = () => {
    form.post('/login')
}
</script>

<template>

    <Head title="Login"></Head>
    <BoxMd>
        <form @submit.prevent="submit">
            <Input id="email" type="email" v-model="form.email">Email</Input>
            <Input id="password" type="password" v-model="form.password">Password</Input>
            <MessageError v-if="page.props.errors?.login">
                {{ page.props.errors.login }}
            </MessageError>
            <div class="flex justify-end mt-4">
                <ButtonPrimary type="submit">Login</ButtonPrimary>
            </div>
        </form>
    </BoxMd>
</template>
