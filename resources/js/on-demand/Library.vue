<template>
    <div>
        <section class="page-header page-header--no-bottom" v-if="this.classes.length > 0">
            <div class="wrapper">
                <div class="page-header__col">
                    <h1 class="page-header__title">
                        <div class="icon icon--member">
                            <img src="/icons/utility/video.svg">
                        </div>
                        On Demand
                    </h1>

                    <h2 class="page-header__sub">Video Library</h2>
                </div>

                <div class="page-header__col">
                    <button @click="displayUploadModal = true" class="button">Upload Video <img src="/icons/utility/add.svg"></button>
                </div>
            </div>
        </section>

        <section class="page-content">
            <div v-if="this.classes.length > 0">
                <div class="list-wrap">
                    <table class="list list--with-hover">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created</th>
                        </thead>
                        <tbody>
                            <tr v-for="item in this.classes">
                                <td><router-link :to="'/app/classes/' + item.id">{{item.name}}</router-link></td>
                                <td>{{item.excerpt}}</td>
                                <td>
                                    <i class="fas fa-circle-notch fa-spin" v-if="!item.processed"></i>&nbsp;
                                    <span :class="item.processed ? 'dot dot--green' : ''"></span>
                                    {{item.processed ? 'Live' : 'Processing'}}
                                </td>
                                <td>{{item.created_human}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <pagination @change_page="change_page" :pagination="this.pagination" :loading="this.loading"></pagination>
            </div>

            <section class="forbidden forbidden--full" v-else-if="!this.loading && this.classes.length == 0">
                <div>
                    <img src="/images/illustrations/video-streaming.svg">
                    <h2>No Videos</h2>
                    <p>Why not upload your first one?</p>
                    <br><br>
                    <button @click="showStoreGymModal()" class="button">Upload Video <i class="fas fa-plus"></i></button>
                </div>
            </section>
        </section>

        <upload-video-modal v-on:cancel="displayUploadModal = false" v-on:complete="displayUploadModal = false" :class="displayUploadModal ? 'modal modal--active' : 'modal'" />
    </div>
</template>

<script>
import axios from 'axios';
import UploadVideoModal from './UploadVideoModal.vue';

export default {
    components: {
        UploadVideoModal
    },

    data() {
        return {
            loading: true,
            classes: [],
            displayUploadModal: false
        }
    },

    mounted() {
        this.loadClasses();
    },

    methods: {
        scrollToTop() {
            document.getElementById('app').scrollIntoView();
        },

        loadClasses(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }

            axios.get('/api/admin/on-demand/library?page=' + page).then(response => {
                this.classes = response.data.data;
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
        },

        deleteOnDemandClass(item) {
            alert('In Development...');
        }
    }
}
</script>
