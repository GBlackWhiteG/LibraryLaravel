<script setup>
import { onMounted, onUpdated, ref } from "vue";
import { useRoute } from "vue-router";
import api from "../api";
import router from "../router";

const accessToken = ref("");
const route = useRoute();

onMounted(() => {
  getToken();
});

onUpdated(() => {
  getToken();
});

const getToken = () => {
  accessToken.value = localStorage.getItem("access_token");
};

const logout = () => {
  api.post("/api/auth/logout")
    .then((res) => {
      localStorage.removeItem("access_token");
      router.push({ path: "/login" });
    })
    .catch((err) => {console.log(err)});
};
</script>

<template>
  <div class="container p-4">
    <div class="d-flex gap-2">
      <router-link :to="{ name: 'book.index' }">Книги</router-link>
      <router-link v-if="accessToken" :to="{ name: 'user.index' }"
        >Пользователи</router-link
      >
      <router-link v-if="!accessToken" :to="{ name: 'user.registration' }"
        >Регистрация</router-link
      >
      <router-link v-if="!accessToken" :to="{ name: 'user.login' }"
        >Войти</router-link
      >
      <a href="" v-if="accessToken" @click.prevent="logout">Выйти</a>
    </div>
    <router-view :key="route.fullPath"></router-view>
  </div>
</template>

<style scoped>
.container {
  background-color: #ffffff;
}
</style>