<template>
  <div>
    <div v-if="isLoading">Loading...</div>
    <div v-if="error">{{ error }}</div>
    <div v-if="data" class="row justify-center q-pa-lg">
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 col-xs-12 q-pa-sm">
        <apexchart
          width="350"
          type="bar"
          :options="chartOptions"
          :series="chartSeries"
        ></apexchart>
      </div>
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 col-xs-12 q-pa-sm">
      
    <apexchart
          type="donut"
          :options="chartPieOptions"
          :series="chartPieData"
        ></apexchart>
        {{ chartPieData}}

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watchEffect } from "vue";
import { useQuery } from "vue-query";
import { usePaymentStore } from "src/stores/payments-store";

const paymentStore = usePaymentStore();
const { data } = useQuery("payments", paymentStore.fetchAllPayments, {
  cacheTime: 0,
});
console.log("this mine23", data);



// const { data: data, isLoading: isLoading, error: error, refetch: refetch } = useQuery("payments", paymentStore.fetchAllPayments, { cacheTime: 0 });

const chartSeries = computed(() => {
  if (data) {
    const you = data.value.sevenDaypay.map(item => item.total_amount);
    return [

      {
        name: "Amount",
        data: you,
      },
    ];
  }
 
});
const chartOptions = computed(() => {
  if (data) {
    return  {
        chart: {
          id: "my-amounts",
          background: "#fff",
          width: "350px", // Use pixels for width
          type: 'bar',
          height:"550px",
        },
        xaxis: {
          // Uncomment and provide categories if needed
          categories: data.value.sevenDaypay.map(item => item.date)
        },
        
      };
  }
 
});

const chartPieOptions = computed(() => {
  if (data) {
    return {
  chart: {
    id: "my-pieamounts",
    background: "#fff",
    width: "350",
  },
  labels: data.value.codeResult.map(item => item.code),
  colors: ["#66DA26", "#2E93fA", "#546E7A", "#E91E63"],
};
  }
 
});


const chartPieData =  computed(() => {
  if (data) {
    const you = data.value.codeResult.map(item => item.count);
    // const you = data.value.sevenDaypay.map(item => item.total_amount);
    return you;
  }
 
});
</script>
