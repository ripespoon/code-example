<template>
    <div>
        <section class="page-header page-header--no-bottom" v-if="this.members.length > 0">
            <div class="wrapper">
                <div class="page-header__col">
                    <h1 class="page-header__title">
                        <div class="icon icon--member">
                            <img src="/icons/standard/user.svg">
                        </div>
                        Members
                    </h1>

                    <h2 class="page-header__sub">All Members</h2>
                </div>

                <div class="page-header__col">
                    <button @click="displayCreateModal = true" class="button">New Member <img src="/icons/utility/add.svg"></button>
                </div>
            </div>
        </section>

        <section class="page-content">
            <div v-if="this.members.length > 0">
                <div class="list-wrap">
                    <table class="list list--no-top list--new list--side list--with-hover">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Created</th>
                        </thead>
                        <tbody>
                            <tr v-for="item in this.members">
                                <td><router-link :to="'/members/' + item.id">{{item.name}}</router-link></td>
                                <td>{{item.email}}</td>
                                <td>{{item.phone_number}}</td>
                                <td>{{item.created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <pagination @change_page="change_page" :pagination="this.pagination" :loading="this.loading"></pagination>
            </div>

            <section class="forbidden forbidden--full" v-else-if="!this.loading && this.members.length == 0">
                <div>
                    <img src="/images/illustrations/video-streaming.svg">
                    <h2>No Members</h2>
                    <p>Why not create your first one?</p>
                    <br><br>
                    <button @click="displayCreateModal = true" class="button">Create Member <i class="fas fa-plus"></i></button>
                </div>
            </section>
        </section>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            loading: true,
            displayCreateModal: false,
            members: [],
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

            axios.get('/api/admin/members?page=' + page).then(response => {
                this.members = response.data.data;
                this.pagination = response.data;
            })
            .catch(error => {
                console.log('ERROR');
                console.log(error)
            })
            .finally(() => this.loading = false);
        },

        change_page(type) {
            this.loading = true;

            if (type === 'previous') {
                this.fetchClasses((this.pagination.current_page - 1));
            } else {
                this.fetchClasses((this.pagination.current_page + 1));
            }

            this.scrollToTop();
        }
    }
}
</script>
