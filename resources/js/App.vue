<template>
    <div>
        <header class="header" v-if="isAuthed">
            <div class="wrapper">
                <p class="header__logo">Company Name</p>

                <div class="header__search">
                    <input type="text" placeholder="Search Users, Videos and Reviews">
                </div>

                <div class="header__account">
                    <div class="header__account-circle header__account-circle--notifications"><i class="fas fa-bell"></i></div>
                    <div class="header__account-circle header__account-circle--me">SM</div>
                    <div class="header__account-circle header__account-circle--logout" @click="logout()"><i class="fas fa-sign-out-alt"></i></div>
                </div>
            </div>
        </header>

        <nav class="nav" v-if="isAuthed">
            <div class="wrapper">
                <ul>
                    <li>
                        <router-link to="/" :class="this.$route.path === '/' ? 'active' : ''">
                            <i class="fas fa-tachometer-alt"></i> My Dashboard
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/admins" :class="this.$route.path.includes('/admins') ? 'active' : ''">
                            <i class="fas fa-user-shield"></i> Admins
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/members" :class="this.$route.path.includes('/members') ? 'active' : ''">
                            <i class="fas fa-running"></i> Members
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/trainers" :class="this.$route.path.includes('/trainers') ? 'active' : ''">
                            <i class="fas fa-user-nurse"></i> Trainers
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/on-demand/library" :class="this.$route.path.includes('/on-demand/library') ? 'active' : ''">
                            <i class="fas fa-video"></i> Video Library
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/on-demand/categories" :class="this.$route.path.includes('/on-demand/categories') ? 'active' : ''">
                            <i class="fas fa-folder"></i> Categories
                        </router-link>
                    </li>
                </ul>
            </div>
        </nav>

        <router-view></router-view>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            admin: {},
            isAuthed: localStorage.getItem('usertoken') ? true : false, // until the loadAuth method has finished we'll go off whether userToken has a value
        }
    },

    watch: {
        $route (to, from){
            /*
             * Until we setup the websocket backend, this will check the user
             * has a valid auth when checking view.
             */
            this.scrollToTop();
            this.loadAuth();
        }
    },

    mounted() {
    },

    methods: {
        scrollToTop() {
            document.getElementById('app').scrollIntoView();
        },

        loadAuth() {
            axios.get('/api/admin/me').then(response => {
                this.admin = response.data;
            })
            .catch(error => {
                this.loading = false;
            });
        },

        logout() {
            localStorage.removeItem('usertoken');
            window.location.href = '/login';
        },
    }
}
</script>
