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
    <form @submit.prevent="submit">
        <label for="email">
            Email
            <input type="email" name="email" id="email" v-model="form.email" />
        </label>
        <label for="password">
            Password
            <input type="password" name="password" id="password" v-model="form.password" />
        </label>
        <span v-if="page.props.errors?.login">
            {{ page.props.errors.login }}
        </span>
        <button type="submit">Login</button>
    </form>
</template>
