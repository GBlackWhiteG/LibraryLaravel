<script setup>
import { onMounted, onUpdated, ref } from "vue";
import { useRoute } from "vue-router";
import api from "../api";
import router from "../router";

const accessToken = ref("");
const role = ref("");
const route = useRoute();

onMounted(() => {
  getData();
});

onUpdated(() => {
  getData();
});

const getData = () => {
  accessToken.value = localStorage.getItem("access_token");
  role.value = localStorage.getItem("role");
};

const logout = () => {
  api.post("/api/auth/logout")
    .then((res) => {
      localStorage.removeItem("access_token");
      localStorage.removeItem("role");
      router.push({ path: "/login" });
    })
    .catch((err) => {console.log(err)});
};
</script>

<template>
  <div class="container p-5">
    <div class="nav-items__wrapper">
      <h1 class="logo-name">Library</h1>
      <div class="d-flex gap-3 nav-items">
        <router-link :to="{ name: 'book.index' }">Книги</router-link>
        <router-link v-if="accessToken && role === 'admin'" :to="{ name: 'user.index' }"
          >Пользователи</router-link
        >
        <router-link v-if="accessToken && role === 'librarian'" :to="{ name: 'book.reservated' }"
          >Забронированные книги</router-link
        >
        <router-link v-if="!accessToken" :to="{ name: 'user.registration' }"
          >Регистрация</router-link
        >
        <router-link v-if="!accessToken" :to="{ name: 'user.login' }"
          >Войти</router-link
        >
        <a href="" v-if="accessToken" @click.prevent="logout">Выйти</a>
      </div>
    </div>
    <router-view :key="route.fullPath"></router-view>
  </div>
</template>

<style scoped>
.container {
  background-color: #ffffff;
}

.nav-items__wrapper {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 0 auto;
}

.nav-items__wrapper a {
  color: #000000;
  font-size: 16px;
  text-decoration: none;
}
</style>