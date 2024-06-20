<script setup>
    import { reactive } from 'vue';
    import router from '../../router';

    const data = reactive({
        title: '',
        author: '',
        publisher: '',
        category: '',
        image_url: ''
    })

    const handleSubmit = () => {
        axios.post('/api/books/store', {
            title: data.title,
            author: data.author,
            publisher: data.publisher,
            category: data.category,
            image_url: data.image_url
        }).then( res => {
            alert('Книга успешно создана');
            router.push({ path: '/books' });
        }).catch( err => {
            alert("Произошла ошибка");
        })
    }
</script>

<template>
    <section>
        <h2>Добавить новую книгу</h2>

        <form @submit.prevent="handleSubmit" class="d-sm-flex flex-column align-items-start gap-2">
            <input type="text" placeholder="Название" v-model="data.title">
            <input type="text" placeholder="Автор" v-model="data.author">
            <input type="text" placeholder="Издательство" v-model="data.publisher">
            
            <select name="" id="" v-model="data.category">
                <option value="category_1">Категория 1</option>
                <option value="category_2">Категория 2</option>
            </select>

            <input type="input" placeholder="Изображение" v-model="data.image_url">

            <input type="submit" value="Сохранить">
        </form>
    </section>
</template>

<style scoped>

</style>
