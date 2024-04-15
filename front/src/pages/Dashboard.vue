<template>
    
    <div class="row justify-center q-pa-lg">
    <!-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 col-xs-12 q-pa-sm">   -->
          <!-- <Bar
    id="my-chart-id"
    :options="chartOptions"
    :data="chartData"
  />
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 col-xs-12 q-pa-sm">
    <Doughnut :options="chartOptions"
    :data="chartData" />
  </div> -->
</div>
<div class="container">
    <Bar v-if="loaded" :data=Payments />
  </div>
</template>


<script>
import { Bar, Doughnut } from 'vue-chartjs'
import { Chart as ChartJS,ArcElement, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
ChartJS.register(ArcElement, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
import { usePaymentStore } from "src/stores/payments-store";
import { useQuery } from "vue-query";
import {computed, ref, onMounted } from 'vue'; 
const paymentStore = usePaymentStore();
export default {
  name: 'Dashboard',
  components: { Bar, Doughnut },
  data: () => ({
    loaded: false,
    chartData: null,
    
    // chartData: {
    //     labels: [ 'January', 'February', 'March', 'January', 'February', 'March' ],
    //     datasets: [ { data: [40, 20, 12, 40, 20, 12] } ]
    //   },
    //   chartOptions: {
    //     responsive: true
    //   }
  }),
 
//   async mounted () {
//     this.loaded = false

//     try {
//             const { userlist } = await fetch('/api/userlist')
//     //   this.chartdata = userlist
//     // this.chartdata.datasets = fetchData(0)
//     const { data: payments, isLoading, isError } = useQuery("payments", () => paymentStore.fetchPayments(0));
      
//       // Assuming paymentStore.fetchPayments returns an array of data
//       this.chartData = {
//         labels: payments.map(payment => payment.phonenumber), // Modify according to your data structure
//         datasets: [{
//           label: 'Payments',
//           backgroundColor: 'blue', // Customize as needed
//           data: payments.map(payment => payment.amount) // Modify according to your data structure
//         }]
//       };
//       this.loaded = true
//     } catch (e) {
//       console.error(e)
//     }
//   }  
setup() {
    const loaded = ref(false);
    const chartData = ref(null);
    const dataMap = ref({});
    onMounted(async () => {
      try {
        const { data: payments, isLoading, isError } = useQuery("payments", () => paymentStore.fetchPayments(0));
        dataMap.value[0] = payments;
        const currentItems = computed(() => dataMap.value[0]);
        // Assuming paymentStore.fetchPayments returns an array of data
        chartData.value = {
           datasets: [{
            label: 'Payments',
            backgroundColor: 'blue', // Customize as needed
            data: currentItems // Modify according to your data structure
          }]
        };

        loaded.value = true;
      } catch (e) {
        console.error(e);
      }
    });

    return { loaded, chartData };
  }

}
</script>
