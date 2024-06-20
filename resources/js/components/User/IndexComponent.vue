<script setup>
    import { onMounted, ref } from 'vue';

    const users = ref([]);

    onMounted(() => {
        getUsers();
    });

    const getUsers = () => {
        axios.get('/api/users').then( res => {
            users.value = res.data;
        });
    }

</script>

<template>
    <section>
        <h2>Пользователи</h2>
        <ol>
            <li v-for="user in users" :key="user.id">{{ user.name }}</li>
        </ol>
    </section>
</template>

<style scoped>

</style>