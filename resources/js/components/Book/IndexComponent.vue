<script setup>
import { onMounted, ref } from "vue";
import api from "../../api";

const role = localStorage.getItem("role");
const books = ref([]);
const searchParams = ref("");

const createUrl = (url) => {
  return `http://127.0.0.1:8000/storage/${url}`;
};

onMounted(() => {
  getBooks();
});

const getBooks = () => {
  if (searchParams.value) {
    api.get(`/api/auth/books?search=${searchParams.value}`).then((res) => {
      books.value = res.data;
    });
  } else {
    api.get(`/api/auth/books`).then((res) => {
      books.value = res.data;
    });
  }
};
</script>

<template>
  <section class="mt-2">
    <div class="buttons_wrapper">
      <input
        v-model="searchParams"
        @input="getBooks"
        type="text"
        placeholder="Поиск..."
      />
      <router-link
        v-if="role === 'librarian'"
        :to="{ name: 'book.create' }"
        class="add-button"
        >Добавить
      </router-link>
    </div>

    <ol class="books">
      <li v-for="book in books" :key="book.id" class="book-item__wrapper">
        <router-link
          :to="{ name: 'book.show', params: { id: book.id } }"
          class="book-item"
        >
          <div class="book-image__wrapper">
            <img :src="createUrl(book.image_url)" alt="" class="book-image" />
          </div>
          <span class="book-name">{{ book.title }}</span>
          <span class="book-author">{{ book.author }}</span>
        </router-link>
      </li>
    </ol>
  </section>
</template>

<style scoped>
.buttons_wrapper {
  display: flex;
  align-items: center;
  gap: 2em;
  margin-bottom: 2em;
}

.add-button {
  display: block;
  color: #000000;
  text-decoration: none;
  border: solid 1px #000000;
  padding: 2px 15px;
}

.books {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 20px;
  list-style: none;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
  padding: 0;
}

.book-item__wrapper {

}

.book-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #000000;
  text-decoration: none;
}

.book-name {
  font-size: 18px;
  text-transform: uppercase;
}

.book-author {
}

.book-image__wrapper {
  width: 100%;
}

.book-image {
  width: 100%;
  max-width: 100%;
}
</style>
