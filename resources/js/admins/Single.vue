<template>
    <div>
        <section class="page-header page-header--no-bottom">
            <div class="wrapper">
                <div class="page-header__col">
                    <h1 class="page-header__title">
                        <div class="icon icon--admin">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        Admins
                    </h1>
                    <h2 class="page-header__sub">Admin #{{this.admin.id}} - {{this.admin.name}}</h2>
                </div>

                <div class="page-header__col">
                </div>
            </div>
        </section>

        <div class="page-content">
            In Development...
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            id: this.$route.params.id,
            loading: true,
            admin: {}
        }
    },

    mounted() {
        this.loadAdmin();
    },

    methods: {
        /*
         * Fetch the single member on page load.
         * @param {none}
         */
        loadAdmin() {
            axios.get('/api/admin/admins/' + this.$route.params.id).then(response => {
                this.admin = response.data;
            })
            .catch(error => {
                console.log('ERROR');
                console.log(error);
            })
            .finally(() => this.loading = false);
        }
    }
}
</script>
