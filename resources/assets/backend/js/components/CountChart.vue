<script>
import { Bar } from 'vue-chartjs';

export default {
    extends: Bar,
    props: [
        'data', 'options',
        'label', 'color',
    ],
    mounted() {
        let labels = [];
        let data = [];
        _.forEach(this.data, function(v, k) {
            labels.push(k);
            data.push(v);
        });
        this.renderChart({
            labels: labels,
            datasets: [
                {
                    label: this.label,
                    backgroundColor: this.color,
                    data: data
                },
                // 'rgba(255, 99, 132)'
                // backgroundColor: 'rgba(54, 162, 235)',
                // backgroundColor: 'rgba(255, 206, 86)',
            ]
        });
    }
};
</script>