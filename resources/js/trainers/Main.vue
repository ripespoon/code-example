<template>
    <div>
        <section class="page-header page-header--no-bottom" v-if="this.trainers.length > 0">
            <div class="wrapper">
                <div class="page-header__col">
                    <h1 class="page-header__title">
                        <div class="icon icon--member">
                            <img src="/icons/standard/user.svg">
                        </div>
                        Trainers
                    </h1>

                    <h2 class="page-header__sub">All Trainers</h2>
                </div>

                <div class="page-header__col">
                    <button @click="displayCreateModal = true" class="button">New Trainer <img src="/icons/utility/add.svg"></button>
                </div>
            </div>
        </section>

        <section class="page-content">
            <div v-if="this.trainers.length > 0">
                <div class="list-wrap">
                    <table class="list list--no-top list--new list--side list--with-hover">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Created</th>
                        </thead>
                        <tbody>
                            <tr v-for="item in this.trainers">
                                <td><router-link :to="'/trainers/' + item.id">{{item.name}}</router-link></td>
                                <td>{{item.email}}</td>
                                <td>{{item.phone_number}}</td>
                                <td>{{item.created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <pagination @change_page="change_page" :pagination="this.pagination" :loading="this.loading"></pagination>
            </div>

            <section class="forbidden forbidden--full" v-else-if="!this.loading && this.trainers.length == 0">
                <div>
                    <img src="/images/illustrations/video-streaming.svg">
                    <h2>No Trainers</h2>
                    <p>Why not create your first one?</p>
                    <br><br>
                    <button @click="displayCreateModal = true" class="button">Create Trainer <i class="fas fa-plus"></i></button>
                </div>
            </section>
        </section>

        <create-trainer-modal v-on:cancel="displayCreateModal = false" v-on:complete="displayCreateModal = false" :class="displayCreateModal ? 'modal modal--active' : 'modal'" />
    </div>
</template>

<script>
import axios from 'axios';
import CreateTrainerModal from './CreateTrainerModal';

export default {
    components: {
        CreateTrainerModal
    },

    data() {
        return {
            loading: true,
            displayCreateModal: false,
            trainers: [],
            pagination: {}
        }
    },

    mounted() {
        this.loadTrainers();
    },

    methods: {
        scrollToTop() {
            document.getElementById('app').scrollIntoView();
        },

        loadTrainers(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }

            axios.get('/api/admin/trainers?page=' + page).then(response => {
                this.trainers = response.data.data;
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
                this.loadTrainers((this.pagination.current_page - 1));
            } else {
                this.loadTrainers((this.pagination.current_page + 1));
            }

            this.scrollToTop();
        }
    }
}
</script>
