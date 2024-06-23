<script setup>
import { reactive } from "vue";
import api from "../../api";
import router from "../../router";

const data = reactive({
  title: "",
  author: "",
  publisher: "",
  category: "",
  image_url: null,
});

const handleFileChange = (e) => {
  data.image_url = e.target.files[0];
};

const handleSubmit = () => {
  const formData = new FormData();
  formData.append("title", data.title);
  formData.append("author", data.author);
  formData.append("publisher", data.publisher);
  formData.append("category", data.category);
  formData.append("image_url", data.image_url);

  api
    .post("/api/auth/books/store", formData)
    .then((res) => {
      alert("Книга успешно создана");
      router.push({ path: "/books" });
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<template>
  <section>
    <h2>Добавить новую книгу</h2>

    <form
      @submit.prevent="handleSubmit"
      class="d-sm-flex flex-column align-items-start gap-2"
    >
      <input type="text" placeholder="Название" v-model="data.title" required />
      <input type="text" placeholder="Автор" v-model="data.author" required />
      <input
        type="text"
        placeholder="Издательство"
        v-model="data.publisher"
        required
      />

      <select name="" id="" v-model="data.category">
        <option value="category_1">Категория 1</option>
        <option value="category_2">Категория 2</option>
      </select>

      <input
        type="file"
        placeholder="Изображение"
        @change="handleFileChange"
        required
      />

      <input type="submit" value="Сохранить" />
    </form>
  </section>
</template>

<style scoped>
</style>
