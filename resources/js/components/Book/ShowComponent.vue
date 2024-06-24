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
  start_reservation: "",
  end_reservation: "",
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
    data.description = res.data.description;
    data.image_url = res.data.image_url;
    data.issued_user = res.data.issued_user;
    data.start_reservation = res.data.start_reservation;
    data.end_reservation = res.data.end_reservation;

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
  <section class="mt-2">
    <div class="book-items">
      <div class="book-image__wrapper">
        <img :src="data.image_url" alt="image" class="book-image" />
      </div>
      <div class="book-info">
        <h2>{{ data.title }}</h2>
        <p>Автор: {{ data.author }}</p>
        <p>Издатель{{ data.publisher }}</p>
        <p>Жанр: {{ data.category }}</p>
        <span>Краткое описание:</span>
        <p>{{ data.description }}</p>

        <div class="buttons">
          <router-link
            v-if="role === 'librarian'"
            x
            :to="{ name: 'book.edit', params: { id: route.params.id } }"
            >Изменить</router-link
          >
          <a href="" v-if="role === 'librarian'" @click.prevent="deleteBook()"
            >Удалить книгу</a
          >
        </div>
        <div v-if="role === 'user'">
          <div v-if="data.user_id === 0">
            <div class="d-flex flex-row gap-3">
              <div class="d-flex flex-column">
                <label for="start">Начало брони:</label>
                <input
                  id="start"
                  type="date"
                  :min="minDate"
                  :max="maxDate"
                  :value="startDate"
                />
              </div>
              <div class="d-flex flex-column">
                <label for="end">Конец брони:</label>
                <input
                  id="end"
                  type="date"
                  :min="minDate"
                  :max="maxDate"
                  :value="endDate"
                />
              </div>
            </div>
            <button @click="reservateBook" class="mt-3 button">
              Забронировать
            </button>
          </div>
          <div
            v-else-if="isReserved"
            class="d-flex flex-column align-items-start gap-2"
          >
            <span
              >Книга забронирована с
              {{
                data.start_reservation
                  .split(" ")[0]
                  .replace("-", ".")
                  .replace("-", ".")
              }}
              до
              {{
                data.end_reservation
                  .split(" ")[0]
                  .replace("-", ".")
                  .replace("-", ".")
              }}</span
            >
            <span class="warning">Заберите книгу в библиотеке</span>
            <button @click="unReservateBook" class="button">
              Отменить бронь
            </button>
          </div>
          <div v-if="isIssued" class="d-flex flex-column align-items-start">
            <span class="warning">Книга у вас</span>
            <span
              >Крайник срок брони:
              {{
                data.end_reservation
                  .split(" ")[0]
                  .replace("-", ".")
                  .replace("-", ".")
              }}</span
            >
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.book-items {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2em;
}

.book-image {
  width: 100%;
  max-width: 500px;
}

.book-info {
  grid-column: 2 / 4;
}

.buttons {
  display: flex;
  flex-direction: row;
  gap: 1em;
}

.buttons a,
.button {
  color: #000000;
  text-decoration: none;
  border: solid 1px #000000;
  background-color: transparent;
  padding: 3px 15px;
}

.warning {
  color: red;
  padding: 5px 15px;
  border: solid 2px red;
}
</style>
