<script setup>
import { reactive, ref } from "vue";
import router from "../../router";

const error = ref("");

const data = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const store = () => {
  axios
    .post("/api/users", data)
    .then((res) => {
      localStorage.access_token = res.data.access_token;
      localStorage.role = res.role;
      router.push({ path: "/books" });
    })
    .catch((err) => {
      console.log(err);
      error.value = err.response.data.error;
    });
};
</script>

<template>
  <form>
    <input type="text" v-model="data.name" placeholder="Имя" required/>
    <input type="email" v-model="data.email" placeholder="Эл. почта" required/>
    <input type="password" v-model="data.password" placeholder="Пароль" required/>
    <input
      type="password"
      v-model="data.password_confirmation"
      placeholder="Подтверждение пароля"
      required
    />
    <input type="submit" @click.prevent="store" />
    <p v-if="error">{{ error }}</p>
  </form>
</template>

<style scoped>
</style>