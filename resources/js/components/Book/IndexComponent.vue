<script setup>
import { onMounted, ref } from "vue";
import api from "../../api";

const books = ref([]);

onMounted(() => {
  getBooks();
});

const getBooks = () => {
  api.get("/api/auth/books").then((res) => {
    books.value = res.data;
  });
};
</script>

<template>
  <section>
    <h2>Книги</h2>

    <ol>
      <li v-for="book in books" :key="book.id">
        <router-link :to="{ name: 'book.show', params: { id: book.id } }">{{
          book.title
        }}</router-link>
      </li>
    </ol>

    <router-link :to="{ name: 'book.create' }"
      >Добавить новую книгу</router-link
    >
  </section>
</template>

<style scoped>
</style>
