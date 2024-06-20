import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/books', component: () => import('./components/Book/IndexComponent.vue'),
        name: 'book.index'
    },
    {
        path: '/books/create', component: () => import('./components/Book/CreateComponent.vue'),
        name: 'book.create'
    },
    {
        path: '/books/:id', component: () => import('./components/Book/ShowComponent.vue'),
        name: 'book.show'
    },
    {
        path: '/books/:id/edit', component: () => import('./components/Book/EditComponent.vue'),
        name: 'book.edit'
    },

    {
        path: '/users', component: () => import('./components/User/IndexComponent.vue'),
        name: 'user.index'
    },
    {
        path: '/registration', component: () => import('./components/User/RegistrationComponent.vue'),
        name: 'user.registration'
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
