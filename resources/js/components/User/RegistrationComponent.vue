<script setup>
    import { reactive } from 'vue';

    const data = reactive({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    });

    const store = () => {
        console.log(data);
        axios.post('/api/users', {
            name: data.name,
            email: data.email,
            password: data.password,
            password_confirmation: data.password_confirmation
        }).then( res => {
            console.log(res);
        }).catch( err => {
            console.log(err);
        });
    }

</script>

<template>
    <form action="">
        <input type="text" v-model="data.name" placeholder="Имя">
        <input type="email" v-model="data.email" placeholder="Эл. почтв">
        <input type="password" v-model="data.password" placeholder="Пароль">
        <input type="password" v-model="data.password_confirmation" placeholder="Подтверждение пароля">
        <input type="submit" @click.prevent="store">
    </form>
</template>

<style scoped>

</style>