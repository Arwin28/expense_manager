<script>
import { Pie } from "vue-chartjs";

export default {
  extends: Pie,
  props: {
    label: {
      type: String
    },
    chartData: {
      type: Array
    },
    options: {
      type: Object
    },
    chartColors: {
      type: Object
    }
  },
  mounted() {
    const category = this.chartData.map(d => d.category).reverse();
    const totals = this.chartData.map(d => d.total).reverse();

    const {
      borderColor,
      pointBorderColor,
      pointBackgroundColor,
      backgroundColor
    } = this.chartColors;

    this.renderChart(
      {
        labels: category,
        hoverBackgroundColor: "red",
        hoverBorderWidth: 10,
        datasets: [
          {
            label: this.label,
            data: totals,
            pointBorderColor: pointBorderColor,
            pointBackgroundColor: pointBackgroundColor,
            backgroundColor: ["#41B883", "#E46651", "#00D8FF"],
          }
        ]
      },
      this.options
    );
  }
};
</script>