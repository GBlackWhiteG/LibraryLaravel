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
    })
    .catch((err) => {
      error.value = err.response.data.error;
    });
};
</script>

<template>
  <section class="mt-2">
    <form class="d-flex flex-column align-items-center gap-2">
      <h2>Вход в аккаунт</h2>
      <div class="form-item">
        <label for="email">Эл.почта</label>
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
          type="password"
          v-model="data.password"
          required
        />
      </div>
      <input type="submit" @click.prevent="login" class="button" />
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