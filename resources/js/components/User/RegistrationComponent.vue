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
  <section class="mt-2">
    <form class="d-flex flex-column align-items-center gap-2">
      <h2>Регистрация</h2>
      <div class="form-item">
        <label for="name">Имя</label>
        <input
          id="name"
          type="text"
          v-model="data.name"
          required
        />
      </div>
      <div class="form-item">
        <label for="email">Эл. почта</label>
        <input
          id="email"
          type="email"
          v-model="data.email"
          required
        />
      </div>
      <div class="form-item">
        <label for="password">Пароль</label>
        <input
          id="password"
          type="password"
          v-model="data.password"
          required
        />
      </div>
      <div class="form-item">
        <label for="password_confirmation">Подтверждение пароля</label>
        <input
          id="password_confirmation"
          type="password"
          v-model="data.password_confirmation"
          required
        />
      </div>
      <input type="submit" @click.prevent="store" class="button" />
      <p v-if="error">{{ error }}</p>
    </form>
  </section>
</template>

<style scoped>
.form-item {
  display: flex;
  flex-direction: column;
}
.button {
  background-color: transparent;
  border: solid 1px #000000;
}
</style>