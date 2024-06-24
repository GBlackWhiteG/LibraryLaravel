<script setup>
import { onMounted, ref } from "vue";
import api from "../../api";

const books = ref([]);

onMounted(() => {
  getBooks();
});

const getBooks = () => {
  api
    .get("/api/auth/books/reservated/0")
    .then((res) => {
      books.value = res.data;
    })
    .catch((err) => {
      console.log(err);
    });
};

const lendBook = (id) => {
  api
    .patch(`/api/auth/books/${id}/lend`)
    .then((res) => {
      getBooks();
    })
    .catch((err) => {
      console.log(err);
    });
};

const pickBook = (id) => {
  api
    .patch(`/api/auth/books/${id}/pick`)
    .then((res) => {
      getBooks();
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<template>
  <section class="d-flex flex-column align-items-center">
    <h2>Забронированные книги</h2>
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>Книга</th>
          <th>Id пользователя</th>
          <th>Имя пользователя</th>
          <th>Выдать</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="book in books" :key="book.id">
          <tr>
            <td>{{ book.id }}</td>
            <td>{{ book.title }}</td>
            <td>{{ book.user_id }}</td>
            <td>{{ book.user_name }}</td>
            <td v-if="!book.issued_user">
              <button @click="lendBook(book.id)" class="button">Выдать</button>
            </td>
            <td v-else-if="book.issued_user">
              <button @click="pickBook(book.id)" class="button">Забрать</button>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </section>
</template>

<style scoped>
table {
  border-collapse: collapse;
  border: solid 1px lightgray;
}

td,
th {
  border: solid 1px lightgray;
  padding: 5px 15px;
}

.button {
  background-color: transparent;
  border: solid 1px #000000;
}
</style>
