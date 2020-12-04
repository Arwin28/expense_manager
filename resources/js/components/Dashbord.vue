<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col">
        <h1 class="text-center">Total Expense Graph</h1>
      </div>
    </div>
    <div class="row mt-5" v-if="arrPositive.length > 0">
      <div class="col">
        <bar-chart
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
import BarChart from "./BarChart";

export default {
  components: {
    BarChart
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
        maintainAspectRatio: false
      }
    };
  },
  async created() {

    const { data } = await axios.get("api/chart");
    var amount1 = 0;

    data.forEach(d => {
      const category = d.category;
      amount1  += parseInt(d.amount);
      this.arrPositive.push({ category, total: amount1 });
    });
  }
};
</script>
