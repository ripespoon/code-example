<template>
    <div>
        <section class="page-header page-header--no-bottom">
            <div class="wrapper">
                <div class="page-header__col">
                    <h1 class="page-header__title">
                        <div class="icon icon--dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        Dashboards
                    </h1>

                    <h2 class="page-header__sub">My Dashboard</h2>
                </div>
            </div>
        </section>

        <section class="page-content">
            <div class="row">
                <div class="three columns">
                    <div class="card">
                        <p class="card__title">New Clients</p>
                        <span class="card__value">52</span>

                        <img class="card__icon" src="/icons/utility/advertising_120.png">
                    </div>
                </div>

                <div class="three columns">
                    <div class="card">
                        <p class="card__title">Total Clients</p>
                        <span class="card__value card__value--green">7421</span>

                        <img class="card__icon" src="/icons/utility/groups_120.png">
                    </div>
                </div>

                <div class="three columns">
                    <div class="card">
                        <p class="card__title">PT Attendance Rate</p>
                        <span class="card__value">87%</span>

                        <img class="card__icon" src="/icons/utility/crossfilter_120.png">
                    </div>
                </div>

                <div class="three columns">
                    <div class="card">
                        <p class="card__title">No. of No Shows</p>
                        <span class="card__value card__value--green">25</span>

                        <img class="card__icon" src="/icons/utility/cancel_transfer_120.png">
                    </div>
                </div>
            </div>

            <br><br>

            <div class="row">
                <div class="six columns">
                    <div class="graph">
                        <p class="graph__title">Sessions Booked</p>
                        <span class="graph__value">135</span>
                        <line-graph :data="sessionBookedData" />
                    </div>
                </div>

                <div class="six columns">
                    <div class="graph">
                        <p class="graph__title">Revenue</p>
                        <span class="graph__value graph__value--green">£98,122.99</span>
                        <line-graph :data="revenueData" />
                    </div>
                </div>
            </div>

            <br><br>

            <div class="row">
                <div class="three columns">
                    <div class="card">
                        <p class="card__title">Workouts Completed</p>
                        <span class="card__value">255</span>

                        <img class="card__icon" src="/icons/utility/smiley_and_people_120.png">
                    </div>
                </div>

                <div class="three columns">
                    <div class="card">
                        <p class="card__title">Videos Watched</p>
                        <span class="card__value card__value--green">2211</span>

                        <img class="card__icon" src="/icons/utility/right_120.png">
                    </div>
                </div>

                <div class="three columns">
                    <div class="card">
                        <p class="card__title">Average PT Rating</p>
                        <span class="card__value">4.1 / 5</span>

                        <img class="card__icon" src="/icons/utility/rating_120.png">
                    </div>
                </div>

                <div class="three columns">
                    <div class="card">
                        <p class="card__title">Clients Lost</p>
                        <span class="card__value card__value--green">91</span>

                        <img class="card__icon" src="/icons/utility/resource_absence_120.png">
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';
import LineGraph from './../graphs/LineGraph.vue';

export default {
    components: {
        LineGraph
    },

    data() {
        return {
            sessionBookedData: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Sessions Booked',
                        borderColor: '#6517FF',
                        backgroundColor: 'rgba(101,23,255, 0.05)',
                        data: [0, 50, 75, 25, 45, 32, 75, 25, 95, 15, 25, 0],
                    }
                ]
            },

            revenueData: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Revenue',
                        borderColor: '#4DC398',
                        backgroundColor: 'rgba(77,195,152,0.05)',
                        data: [4500, 5265, 7123, 9851, 15123, 2500, 12000, 25000, 22500, 12000, 7500, 0],
                    }
                ]
            }
        }
    },

    mounted() {
    },

    methods: {

    }
}
</script>
