<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">My Expenses</h1>
      </div>
    </div>
    <div class="row mt-5" v-if="arrPositive.length > 0">
      <div class="col">
        <pie-chart
          :chartData="arrPositive"
          :options="chartOptions"
          :chartColors="positiveChartColors"
          label="Category"
        />
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import PieChart from "./BarChart";

export default {
  name: "chart",
  components: {
    PieChart
  },
  data() {
    return {
      arrPositive: [],
      positiveChartColors: {
        borderColor: "#077187",
        pointBorderColor: "#0E1428",
        pointBackgroundColor: "#AFD6AC",
        backgroundColor: "#74A57F"
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        pieceLabel: {
        mode: 'percentage',
        precision: 1
      }
      }
    };
  },
  async created() {

    const { data } = await axios.get("api/chart");

    data.forEach(d => {
      const category = d.category;
      const amount = d.amount;
      this.arrPositive.push({ category, total: amount });
    });
  }
};
</script>

<style>
#chart {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
