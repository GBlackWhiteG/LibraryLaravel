<script setup>
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import api from "../../api";

const isModalOpen = ref(false);
const editMode = ref(false);
const editId = ref(0);
const users = ref([]);
const store_data = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});
const update_data = reactive({
  name: "",
  email: "",
  role: "",
});

onMounted(() => {
  getUsers();
});

const getUsers = () => {
  api.get("/api/auth/users").then((res) => {
    users.value = res.data;
  });
};

const onEditMode = (id, name, email, role) => {
  editMode.value = true;
  editId.value = id;

  update_data.name = name;
  update_data.email = email;
  update_data.role = role;
};

const offEditMode = () => {
  updateUser()
    .then((res) => {
      editMode.value = false;
      editId.value = 0;
      getUsers();
    })
    .catch((err) => {
      console.log(err);
    });
};

const storeUser = () => {
  axios
    .post("api/users", store_data)
    .then((res) => {
      getUsers();

      store_data.name = "";
      store_data.email = "";
      store_data.password = "";
      store_data.password_confirmation = "";
    })
    .catch((err) => {
      console.log(err);
    });
};

const updateUser = () => {
  return api.patch(`/api/auth/users/${editId.value}`, update_data);
};

const destroyUser = (id) => {
  api
    .delete(`/api/auth/users/${id}`)
    .then((res) => {
      getUsers();
    })
    .catch((err) => {
      console.log(err);
    });
};
</script>

<template>
  <section class="d-flex flex-column align-items-start">
    <div class="d-flex gap-3 align-items-center">
      <h2>Пользователи</h2>
      <button @click="isModalOpen = true" class="button">Добавить</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>Имя</th>
          <th>Почта</th>
          <th>Роль</th>
          <th>Редактировать</th>
          <th>Удалить</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="user in users" :key="user.id">
          <tr v-if="!editMode || editId !== user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.role }}</td>
            <td>
              <button
                @click="onEditMode(user.id, user.name, user.email, user.role)"
                class="button"
              >
                Изменить
              </button>
            </td>
            <td><button @click="destroyUser(user.id)" class="button">Удалить</button></td>
          </tr>

          <tr v-if="editMode && editId === user.id">
            <td>{{ user.id }}</td>
            <td><input type="text" v-model="update_data.name" required /></td>
            <td>
              <input type="email" v-model="update_data.email" required />
            </td>
            <td><input type="text" v-model="update_data.role" required /></td>
            <td>
              <button @click="offEditMode" class="button">Сохранить</button>
            </td>
            <td>
              <button @click="destroyUser(user.id)" class="button">
                Удалить
              </button>
            </td>
          </tr>
        </template>
      </tbody>
    </table>

    <div class="popup__wrapper" v-show="isModalOpen">
      <div class="popup">
        <h4>Добавить нового пользователя:</h4>
        <form class="d-flex flex-column align-items-center gap-2">
          <div class="d-flex flex-column">
            <label for="name">Имя</label>
            <input id="name" type="text" v-model="store_data.name" required />
          </div>
          <div class="d-flex flex-column">
            <label for="email">Эл.почта</label>
            <input
              id="email"
              type="email"
              v-model="store_data.email"
              required
            />
          </div>
          <div class="d-flex flex-column">
            <label for="password">Пароль</label>
            <input
              id="password"
              type="password"
              v-model="store_data.password"
              required
            />
          </div>
          <div class="d-flex flex-column">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input
              id="password_confirmation"
              type="password"
              v-model="store_data.password_confirmation"
              required
            />
          </div>
          <input type="submit" @click.prevent="storeUser" value="Добавить" />
          <div class="close-button__wrapper" @click="isModalOpen = false">
            <span class="close-button"></span>
          </div>
        </form>
      </div>
    </div>
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

.popup__wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4);
  position: absolute;
  top: 0;
  left: 0;
}

.popup {
  background-color: #ffffff;
  padding: 3em;
  position: relative;
}

.close-button__wrapper {
  cursor: pointer;
  position: absolute;
  top: 25px;
  right: 35px;
}

.close-button {
  position: relative;
}

.close-button::before,
.close-button::after {
  content: "";
  width: 20px;
  height: 3px;
  background: #000000;
  position: absolute;
  top: 50%;
  left: 50%;
}

.close-button::before {
  rotate: 45deg;
}

.close-button::after {
  rotate: 315deg;
}
</style>