import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/books",
        component: () => import("./components/Book/IndexComponent.vue"),
        name: "book.index",
    },
    {
        path: "/books/create",
        component: () => import("./components/Book/CreateComponent.vue"),
        name: "book.create",
    },
    {
        path: "/books/:id",
        component: () => import("./components/Book/ShowComponent.vue"),
        name: "book.show",
    },
    {
        path: "/books/:id/edit",
        component: () => import("./components/Book/EditComponent.vue"),
        name: "book.edit",
    },
    {
        path: "/books/reservated",
        component: () => import("./components/Book/ReservatedBooksComponent.vue"),
        name: "book.reservated",
    },
    {
        path: "/users",
        component: () => import("./components/User/IndexComponent.vue"),
        name: "user.index",
    },
    {
        path: "/registration",
        component: () => import("./components/User/RegistrationComponent.vue"),
        name: "user.registration",
    },
    {
        path: "/login",
        component: () => import("./components/User/LoginComponent.vue"),
        name: "user.login",
    },
    {
        path: "/:catchAll(.*)",
        component: () => import("./components/Book/IndexComponent.vue"),
        name: "404",
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const accessToken = localStorage.getItem("access_token");

    if (!accessToken) {
        if (to.name !== "user.login" && to.name !== "user.registration") {
            return next({
                name: "user.login",
            });
        }
    }

    if (accessToken) {
        if (to.name === "user.login" || to.name === "user.registration") {
            return next({
                name: "book.index",
            });
        }
    }

    next();
});

export default router;
