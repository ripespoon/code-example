<template>
    <div>
        <section class="page-header page-header--no-bottom" v-if="this.categories.length > 0">
            <div class="wrapper">
                <div class="page-header__col">
                    <h1 class="page-header__title">
                        <div class="icon icon--member">
                            <img src="/icons/utility/video.svg">
                        </div>
                        On Demand
                    </h1>

                    <h2 class="page-header__sub">Categories</h2>
                </div>

                <div class="page-header__col">
                    <button @click="displayCreateModal = true" class="button">New Categories <img src="/icons/utility/add.svg"></button>
                </div>
            </div>
        </section>

        <section class="page-content">
            <div v-if="this.categories.length > 0">
                <div class="list-wrap">
                    <table class="list list--no-top list--new list--side list--with-hover">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created</th>
                        </thead>
                        <tbody>
                            <tr v-for="item in this.categories">
                                <td><router-link :to="'/app/classes/' + item.id">{{item.name}}</router-link></td>
                                <td>{{item.description}}</td>
                                <td>{{item.created_human}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <section class="forbidden forbidden--full" v-else-if="!this.loading && this.categories.length == 0">
                <div>
                    <img src="/images/illustrations/video-streaming.svg">
                    <h2>No Categories</h2>
                    <p>Why not create your first one?</p>
                    <br><br>
                    <button @click="displayCreateModal = true" class="button">Create Category <i class="fas fa-plus"></i></button>
                </div>
            </section>
        </section>

        <create-category-modal v-on:cancel="displayCreateModal = false" v-on:complete="displayCreateModal = false" :class="displayCreateModal ? 'modal modal--active' : 'modal'" />
    </div>
</template>

<script>
import axios from 'axios';
import CreateCategoryModal from './CreateCategoryModal.vue';

export default {
    components: {
        CreateCategoryModal
    },

    data() {
        return {
            loading: true,
            categories: [],
            displayCreateModal: false
        }
    },

    mounted() {
        this.loadCategories();
    },

    methods: {
        loadCategories() {
            axios.get('/api/admin/on-demand/categories').then(response => {
                this.categories = response.data;
            })
            .catch(error => {
                console.log('ERROR');
                console.log(error)
            })
            .finally(() => this.loading = false);
        },

        deleteCategory(item) {
            alert('in development');
        }
    }
}
</script>
