<script setup>
import { reactive, ref } from "vue";
import router from "../../router";

const error = ref("");

const data = reactive({
  email: "",
  password: "",
});

const login = () => {
  axios
    .post("/api/auth/login", data)
    .then((res) => {
      localStorage.access_token = res.data.access_token;
      localStorage.role = res.data.role;
      router.push({ path: "/books" });
    }).catch((err) => {
      error.value = err.response.data.error;
    });
};
</script>

<template>
  <form>
    <input type="email" v-model="data.email" placeholder="Эл. почта" required />
    <input type="password" v-model="data.password" placeholder="Пароль" required />
    <input type="submit" @click.prevent="login" />
    <p v-if="error">{{ error }}</p>
  </form>
</template>

<style scoped>
</style>