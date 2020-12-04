/*===================================================
    File: Chartsjsvue.vue
  ===================================================*/
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  data () {
    return {
      datacollection: {
        labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
        datasets: [
          {
            label: '1st Dataset hello',
            backgroundColor: 'rgba(52,65,84, 0.3)',
            bordercolor: '#344154"',
            hoverBackgroundColor: "#344154",
            data: [40, 20, 12, 39]
          },
          {
            label: '2nd Dataset',
            backgroundColor: 'rgba(130,191,163, 0.5)',
            bordercolor: '#82BFA3"',
            hoverBackgroundColor: "#82BFA3",
            data: [50, 70, 22, 55]
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          datalabels: {
            display: false
          }
        }
      }
    }
  },
  mounted () {
    this.renderChart(this.datacollection, this.options)
  }
}
