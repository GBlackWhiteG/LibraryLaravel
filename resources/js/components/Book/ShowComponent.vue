<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { useRoute } from "vue-router";
import api from "../../api";
import router from "../../router";

const currentDate = new Date();
const minDate = currentDate.toISOString().split("T")[0];
const maxDate = new Date(currentDate.setDate(currentDate.getDate() + 30))
  .toISOString()
  .split("T")[0];

const userId = ref(0);
const role = localStorage.getItem("role");
const route = useRoute();
const data = reactive({
  id: 0,
  title: "",
  author: "",
  publisher: "",
  category: "",
  image_url: "",
  user_id: 0,
  issued_user: false,
});

const startDate = ref(minDate);
const endDate = ref(maxDate);
const reservation_data = reactive({
  start_reservation: "",
  end_reservation: "",
});

const isReserved = computed(
  () => userId.value === data.user_id && !data.issued_user
);
const isIssued = computed(
  () => userId.value === data.user_id && data.issued_user
);

/*
const imageUrl = computed(
  () => `storage/app/public/${data.image_url}`
);
*/

onMounted(() => {
  getBook();
  getUserId();
});

const getBook = () => {
  api.get(`/api/auth/books/${route.params.id}`).then((res) => {
    data.id = res.data.id;
    data.title = res.data.title;
    data.author = res.data.author;
    data.publisher = res.data.publisher;
    data.category = res.data.category;
    data.image_url = res.data.image_url;
    data.issued_user = res.data.issued_user;

    data.user_id = res.data.user_id !== null ? res.data.user_id : 0;
  });
};

const getUserId = () => {
  api
    .get("/api/auth/users/id")
    .then((res) => {
      userId.value = res.data;
    })
    .catch((err) => {
      console.log(err);
    });
};

const reservateBook = () => {
  reservation_data.start_reservation = startDate;
  reservation_data.end_reservation = endDate;
  api
    .patch(`/api/auth/books/${data.id}/reservation`, reservation_data)
    .then((res) => {
      alert("Книга забронирована");
      getBook();
    })
    .catch((err) => {
      console.log(err);
    });
};

const unReservateBook = () => {
  api
    .patch(`/api/auth/books/${data.id}/unreservation`)
    .then((res) => {
      alert("Бронь отменена");
      getBook();
    })
    .catch((err) => {
      console.log(err);
    });
};

const deleteBook = () => {
  api.delete(`/api/auth/books/${route.params.id}`).then((res) => {
    alert("Книга успешно удалена");
    router.push({ path: "/books" });
  });
};
</script>

<template>
  <h2>{{ data.title }}</h2>
  <p>{{ data.author }}</p>
  <p>{{ data.publisher }}</p>
  <p>{{ data.category }}</p>
  <img :src='data.image_url' alt="image">
  <div v-if="role === 'user'">
    <div v-if="data.user_id === 0" class="d-flex flex-column align-items-start">
      <label for="start">Начало брони:</label>
      <input id="start" type="date" :min="minDate" :max="maxDate" :value="startDate" />
      <label for="end">Конец брони:</label>
      <input id="end" type="date" :min="minDate" :max="maxDate" :value="endDate" />
      <button @click="reservateBook">Забронировать</button>
    </div>
    <div v-else-if="isReserved">
      <p>Заберите книгу в библиотеке</p>
      <button @click="unReservateBook">Отменить бронь</button>
    </div>
    <p v-if="isIssued">Книга у вас</p>
  </div>

  <router-link
    v-if="role === 'librarian'"
    x
    :to="{ name: 'book.edit', params: { id: route.params.id } }"
    >Изменить</router-link
  >
  <a href="" v-if="role === 'librarian'" @click.prevent="deleteBook()"
    >Удалить книгу</a
  >
</template>

<style scoped>
</style>
