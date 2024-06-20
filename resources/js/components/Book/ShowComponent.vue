<script setup>
    import { onMounted, reactive } from "vue";
    import { useRoute } from 'vue-router';
    import router from '../../router';

    const route = useRoute();

    const data = reactive({
        title: '',
        author: '',
        publisher: '',
        category: '',
        image_url: ''
    })

    onMounted(() => {
        getBook();
    })

    const getBook = () => {
        axios.get(`/api/books/${route.params.id}`)
        .then( res => {
            data.title = res.data.title;
            data.author = res.data.author;
            data.publisher = res.data.publisher;
            data.category = res.data.category;
            data.image_url = res.data.image_url;
        });
    }

    const deleteBook = () => {
        axios.delete(`/api/books/${route.params.id}`)
        .then( res => {
            alert('Книга успешно удалена');
            router.push({ path: '/books' });
        });
    }
</script>

<template>
    <h2>{{ data.title }}</h2>
    <p>{{ data.author }}</p>
    <p>{{ data.publisher }}</p>
    <p>{{ data.category }}</p>
    <p>{{ data.image_url }}</p>

    <router-link :to="{ name: 'book.edit', params: { id: route.params.id } }">Изменить</router-link><br>
    <a href="" @click.prevent="deleteBook()">Удалить книгу</a>
</template>

<style scoped>

</style>
