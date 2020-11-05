<template>
    <div>
        <section class="page-header page-header--no-bottom" v-if="this.admins.length > 0">
            <div class="wrapper">
                <div class="page-header__col">
                    <h1 class="page-header__title">
                        <div class="icon icon--admin">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        Admins
                    </h1>

                    <h2 class="page-header__sub">All Administrators</h2>
                </div>

                <div class="page-header__col">
                    <button @click="displayCreateModal = true" class="button">New Admin <img src="/icons/utility/add.svg"></button>
                </div>
            </div>
        </section>

        <section class="page-content">
            <div v-if="this.admins.length > 0">
                <div class="list-wrap">
                    <table class="list list--no-top list--new list--side list--with-hover">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Created</th>
                        </thead>
                        <tbody>
                            <tr v-for="item in this.admins">
                                <td><router-link :to="'/admins/' + item.id">{{item.name}}</router-link></td>
                                <td>{{item.email}}</td>
                                <td>{{item.phone_number}}</td>
                                <td>{{item.created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <pagination @change_page="change_page" :pagination="this.pagination" :loading="this.loading"></pagination>
            </div>

            <section class="forbidden forbidden--full" v-else-if="!this.loading && this.admins.length == 0">
                <div>
                    <img src="/images/illustrations/video-streaming.svg">
                    <h2>No Administrators</h2>
                    <p>Why not create your first one?</p>
                    <br><br>
                    <button @click="displayCreateModal = true" class="button">Create Admin <i class="fas fa-plus"></i></button>
                </div>
            </section>
        </section>

        <create-admin-modal v-on:cancel="displayCreateModal = false" v-on:complete="displayCreateModal = false" :class="displayCreateModal ? 'modal modal--active' : 'modal'" />
    </div>
</template>

<script>
import axios from 'axios';
import CreateAdminModal from './CreateAdminModal.vue';

export default {
    components: {
        CreateAdminModal
    },

    data() {
        return {
            loading: true,
            displayCreateModal: false,
            admins: [],
            pagination: {}
        }
    },

    mounted() {
        this.loadMembers();
    },

    methods: {
        scrollToTop() {
            document.getElementById('app').scrollIntoView();
        },

        loadMembers(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }

            axios.get('/api/admin/admins?page=' + page).then(response => {
                this.admins = response.data.data;
                this.pagination = response.data;
            })
            .catch(error => {
                console.log('ERROR');
                console.log(error)
            })
            .finally(() => this.loading = false);
        },

        change_page(type) {
            alert('TODO: Add pagination');
        }
    }
}
</script>
