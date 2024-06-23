<script setup>
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import api from "../../api";

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
  <section>
    <h2>Пользователи</h2>
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
              >
                Изменить
              </button>
            </td>
            <td><button @click="destroyUser(user.id)">Удалить</button></td>
          </tr>

          <tr v-if="editMode && editId === user.id">
            <td>{{ user.id }}</td>
            <td><input type="text" v-model="update_data.name" required /></td>
            <td>
              <input type="email" v-model="update_data.email" required />
            </td>
            <td><input type="text" v-model="update_data.role" required /></td>
            <td><button @click="offEditMode">Сохранить</button></td>
            <td><button @click="destroyUser(user.id)">Удалить</button></td>
          </tr>
        </template>
      </tbody>
    </table>

    <h4>Добавить нового пользователя:</h4>
    <form class="d-flex flex-column align-items-start gap-2">
      <input type="text" v-model="store_data.name" required />
      <input type="email" v-model="store_data.email" required />
      <input type="password" v-model="store_data.password" required />
      <input
        type="password"
        v-model="store_data.password_confirmation"
        required
      />
      <input type="submit" @click.prevent="storeUser" value="Добавить" />
    </form>
  </section>
</template>

<style scoped>
td,
th {
  padding: 5px 10px;
}
</style>