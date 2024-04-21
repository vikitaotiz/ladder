<!-- <template>
  <div>
    <apexchart
      width="500"
      type="bar"
      :options="chartOptions"
      :series="series"
    ></apexchart>
      </div>
</template> -->

<template>
  <div v-if="status === 'loading'">Loading...</div>
  <div v-else-if="status === 'error'">Error fetching data</div>
  <div v-else>
    <vue-apex-charts :options="chartOptions" :series="series" type="bar" height="350" />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { usePaymentStore } from "src/stores/payments-store";
import { useQuery } from "vue-query";
import VueApexCharts from 'vue3-apexcharts';

const paymentStore = usePaymentStore();

const {  data: payments, status} = useQuery("payments", () => paymentStore.fetchPayments());
console.log("mydata", payments);
payments.forEach(payment => {
  const amount = payment.amount;
  console.log('Payment amount:', amount);
});

if (status === "loading") {
  console.log("Loading...");
} else if (status === "error") {
  console.log("Error fetching data");
}
const series = ref([
{
          name: "series-1",
          data: payments,
        },
]);
const chartOptions = ref({
  chart: {
    id: 'vue-chart',
    toolbar: {
      show: false,
    },
  },
  xaxis: {
    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
  },
});

// if (true) {
//   chartOptions.value.xaxis.categories = data.categories;
//   series.value = [{
//     name: 'Series 1',
//     data: [30, 40, 45, 50, 49, 60, 70, 81],
//     }];
// }
</script>



<!-- <script>
import VueApexCharts from "vue3-apexcharts";

export default {
  components: {
    apexchart: VueApexCharts,
  },
  data: function() {
    return {
      chartOptions: {
        chart: {
          id: "vuechart-example",
        },
        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
        },
      },
      series: [
        {
          name: "series-1",
          data: [30, 40, 45, 50, 49, 60, 70, 81],
        },
      ],
    };
  },
  methods: {
    updateChart() {
      const max = 90;
      const min = 20;
      const newData = this.series[0].data.map(() => {
        return Math.floor(Math.random() * (max - min + 1)) + min;
      });

      const colors = ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0"];

      // Make sure to update the whole options config and not just a single property to allow the Vue watch catch the change.
      this.chartOptions = {
        colors: [colors[Math.floor(Math.random() * colors.length)]],
      };
      // In the same way, update the series option
      this.series = [
        {
          data: newData,
        },
      ];
    },
  },
};
</script> -->
