<script>

</script>

<template>
    <div class="container p-4">
        <div class="d-flex gap-2">
            <router-link :to="{ name: 'book.index' }">Книги</router-link>
            <router-link :to="{ name: 'user.index' }">Пользователи</router-link>
            <router-link :to="{ name: 'user.registration' }">Регистрация</router-link>
            <router-link :to="{ name: 'user.registration' }">Войти</router-link>
        </div>
        <router-view></router-view>
    </div>
</template>

<style scoped>
    .container {
        background-color: #ffffff;
    }
</style>