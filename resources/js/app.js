import Vue from 'vue'
import VueRouter from 'vue-router';
import axios from 'axios';

/*
 * Add the Authorization header to every axios request.
 */
const token = localStorage.getItem('usertoken')

if (token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

/*
 * Very basic validation to check if the userToken has a value
 * If it does: direct user to the main dashboard.
 */
const ifNotAuthenticated = (to, from, next) => {
    if (!token) {
        next()
        return
    }
    next('/')
}

/*
 * Similar to above however checks if the userToken does not have a value
 * If it doesn't: direct user to the login page.
 */
const ifAuthenticated = (to, from, next) => {
    if (token) {
        next()
        return
    }

    next('/login')
}

Vue.component('App', require('./App.vue').default);

import Login from './auth/Login.vue';
import MyDashboard from './dashboards/MyDashboard.vue';

import OnDemandLibrary from './on-demand/Library.vue';
import OnDemandCategories from './on-demand/Categories.vue';

import MemberList from './members/Main.vue';
import MemberSingle from './members/Single.vue';

import TrainerList from './trainers/Main.vue';
import TrainerSingle from './trainers/Single.vue';

import AdminList from './admins/Main.vue';
import AdminSingle from './admins/Single.vue';

export const routes = [
    { path: '/login', component: Login, name: 'Login', beforeEnter: ifNotAuthenticated },

    { path: '/', component: MyDashboard, name: 'MyDashboard', beforeEnter: ifAuthenticated },

    { path: '/on-demand/library', component: OnDemandLibrary, name: 'OnDemandLibrary', beforeEnter: ifAuthenticated },
    { path: '/on-demand/categories', component: OnDemandCategories, name: 'OnDemandCategories', beforeEnter: ifAuthenticated },

    { path: '/members', component: MemberList, name: 'MemberList', beforeEnter: ifAuthenticated },
    { path: '/members/:id', component: MemberSingle, name: 'MemberSingle', beforeEnter: ifAuthenticated },

    { path: '/trainers', component: TrainerList, name: 'TrainerList', beforeEnter: ifAuthenticated },
    { path: '/trainers/:id', component: TrainerSingle, name: 'TrainerSingle', beforeEnter: ifAuthenticated },

    { path: '/admins', component: AdminList, name: 'AdminList', beforeEnter: ifAuthenticated },
    { path: '/admins/:id', component: AdminSingle, name: 'AdminSingle', beforeEnter: ifAuthenticated },
];

Vue.component('pagination', require('./components/Pagination.vue').default);

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
});

new Vue({
    el: '#app',
    components: {},
    router
});
