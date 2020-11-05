<template>
    <div>
        <section class="page-header page-header--no-bottom">
            <div class="wrapper">
                <div class="page-header__col">
                    <h1 class="page-header__title">
                        <div class="icon icon--member">
                            <img src="/icons/standard/user.svg">
                        </div>
                        Trainers
                    </h1>
                    <h2 class="page-header__sub">Trainer #{{this.member.id}} - {{this.member.name}}</h2>
                </div>

                <div class="page-header__col">
                </div>
            </div>
        </section>

        <div class="page-content">
            <section class="tab tab--bottom">
                <ul>
                    <li :class="this.tab === 'activity' ? 'active' : ''"><a href="#">Performance · November</a></li>
                    <li :class="this.tab === 'bookings' ? 'active' : ''"><a href="#">Bookings</a></li>
                    <li :class="this.tab === 'clients' ? 'active' : ''"><a href="#">Clients</a></li>
                    <li :class="this.tab === 'activity-log' ? 'active' : ''"><a href="#">Activity Log</a></li>
                </ul>
            </section>

            <div class="dashboard-widget dashboard-widget--grey dashboard-widget--four">
                <div class="dashboard-widget__col">
                    <div class="dashboard-widget__row">
                        <div class="dashboard-widget__row-title">Revenue</div>
                        <div class="dashboard-widget__row-value">£424.99 <small>· £320</small></div>
                        <div class="dashboard-widget__row-percentage dashboard-widget__row-percentage--green">
                            <i class="fas fa-chevron-up"></i>

                            <span>50%</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-widget__col">
                    <div class="dashboard-widget__row">
                        <div class="dashboard-widget__row-title">New Clients</div>
                        <div class="dashboard-widget__row-value">6 <small>· 1</small></div>
                        <div class="dashboard-widget__row-percentage dashboard-widget__row-percentage--green">
                            <i class="fas fa-chevron-up"></i>

                            <span>600%</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-widget__col">
                    <div class="dashboard-widget__row">
                        <div class="dashboard-widget__row-title">Completed Sessions</div>
                        <div class="dashboard-widget__row-value">15 <small>· 20</small></div>
                        <div class="dashboard-widget__row-percentage dashboard-widget__row-percentage--red">
                            <i class="fas fa-chevron-down"></i>

                            <span>25%</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-widget__col">
                    <div class="dashboard-widget__row">
                        <div class="dashboard-widget__row-title">Average Rating</div>
                        <div class="dashboard-widget__row-value">3.7 <small>· 2.2</small></div>
                        <div class="dashboard-widget__row-percentage dashboard-widget__row-percentage--green">
                            <i class="fas fa-chevron-up"></i>

                            <span>1.5 Stars</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            id: this.$route.params.id,
            tab: 'activity',
            loading: true,
            member: {}
        }
    },

    mounted() {
        this.loadMember();
    },

    methods: {
        /*
         * Fetch the single member on page load.
         * @param {none}
         */
        loadMember() {
            axios.get('/api/admin/members/' + this.$route.params.id).then(response => {
                this.member = response.data;
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
