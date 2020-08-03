import Vue from 'vue';
import Router from 'vue-router';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

Vue.use(Router);

export const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/login',
            component: Login
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/todotasks',
            name: 'todotasks',
            // lazy-loaded
            component: () => import('./components/ToDoTask.vue')
        },
        {
            path: '/admin',
            name: 'admin',
            // lazy-loaded
            component: () => import('./components/admin/Users.vue')
        },
    ],
});
