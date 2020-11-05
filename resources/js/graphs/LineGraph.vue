<script>
import axios from 'axios';
import { Line } from 'vue-chartjs';

export default {
    props: {
        data: Object
    },

    extends: Line,

    mounted() {
        this.renderChart(this.data, this.options);
    },

    data: () => ({
        options: {
            layout: {
                padding: {
                    left: 30,
                    right: 30,
                    top: 30,
                    bottom: 30
                }
            },
            maintainAspectRatio: false,
            legend: {
                display: false,
                position: 'bottom',
                align: 'start',
                labels: {
                    padding: 25,
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0)",
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: "rgba(0, 0, 0, 0.035)",
                    }
                }]
            }
        }
    })
}
</script>
