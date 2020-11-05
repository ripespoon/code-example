<template>
    <div>
        <section class="page-header page-header--no-bottom">
            <div class="wrapper">
                <div class="page-header__col">
                    <h1 class="page-header__title">
                        <div class="icon icon--member">
                            <img src="/icons/standard/user.svg">
                        </div>
                        Members
                    </h1>
                    <h2 class="page-header__sub">Members #{{this.member.id}} - {{this.member.name}}</h2>
                </div>

                <div class="page-header__col">
                </div>
            </div>
        </section>

        <div class="page-content">
            <section class="info info--red info--bottom">
                <p><i class="fas fa-info-circle"></i> This members email address <strong>{{ this.member.email }}</strong> has been added to our suppression list. This means we have been informed by our email service provider that it cannot deliver emails to this mailbox.<br><br>This could mean the email does not exist due to a typo.</p>
            </section>

            <section class="tab tab--bottom">
                <ul>
                    <li :class="this.tab === 'activity' ? 'active' : ''"><a href="#">Activity · Last 30 Days</a></li>
                    <li :class="this.tab === 'bookings' ? 'active' : ''"><a href="#">Bookings</a></li>
                    <li :class="this.tab === 'orders' ? 'active' : ''"><a href="#">Payment History</a></li>
                    <li :class="this.tab === 'assessments' ? 'active' : ''"><a href="#">Assessments</a></li>
                    <li :class="this.tab === 'activity-log' ? 'active' : ''"><a href="#">Activity Log</a></li>
                </ul>
            </section>

            <div class="dashboard-widget dashboard-widget--grey dashboard-widget--four">
                <div class="dashboard-widget__col">
                    <div class="dashboard-widget__row">
                        <div class="dashboard-widget__row-title">Sessions Booked</div>
                        <div class="dashboard-widget__row-value">12 <small>· 2</small></div>
                        <div class="dashboard-widget__row-percentage dashboard-widget__row-percentage--green">
                            <i class="fas fa-chevron-up"></i>

                            <span>600%</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-widget__col">
                    <div class="dashboard-widget__row">
                        <div class="dashboard-widget__row-title">Completed Sessions</div>
                        <div class="dashboard-widget__row-value">6 <small>· 3</small></div>
                        <div class="dashboard-widget__row-percentage dashboard-widget__row-percentage--green">
                            <i class="fas fa-chevron-up"></i>

                            <span>100%</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-widget__col">
                    <div class="dashboard-widget__row">
                        <div class="dashboard-widget__row-title">On Demand Videos Watched</div>
                        <div class="dashboard-widget__row-value">15 <small>· 20</small></div>
                        <div class="dashboard-widget__row-percentage dashboard-widget__row-percentage--red">
                            <i class="fas fa-chevron-down"></i>

                            <span>25%</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-widget__col">
                    <div class="dashboard-widget__row">
                        <div class="dashboard-widget__row-title">Workouts Completed</div>
                        <div class="dashboard-widget__row-value">3 <small>· 1</small></div>
                        <div class="dashboard-widget__row-percentage dashboard-widget__row-percentage--red">
                            <i class="fas fa-chevron-down"></i>

                            <span>33%</span>
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
