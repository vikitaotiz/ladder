<template>
  <div class="q-pa-md">
    <q-btn-toggle
      name="genre"
      v-model="genre"
      push
      glossy
      toggle-color="teal"
      :options="[
        { label: 'All', value: 2 },
        { label: 'Successful', value: 1 },
        { label: 'Canceled', value: 0 },
        { label: 'Incomplete', value: null },
      ]"
       @change="updateResultCode"
    />
    <q-table
      title="Payments Records"
      :rows="payments"
      row-key="id"
      :columns="columns"
    >
      <template #top-right>
        <q-btn v-if="isLoading" color="primary" label="Loading..." loading />
      </template>
    </q-table>
  </div>
</template>

<script setup>
import { ref, computed, watchEffect } from 'vue';
import { usePaymentStore } from "src/stores/payments-store";
import { useQuery } from "vue-query";

const genre = ref('All');
const resultCode = ref(2); // Default value

const paymentStore = usePaymentStore();

// // Log before invoking useQuery
// console.log("Calling useQuery...");
// const {
//   data: payments,
//   isLoading,
//   isError,
// } = useQuery("payments", () => {
//   console.log("useQuery is invoked");
//   console.log(genre.value);
//   return paymentStore.fetchPayments(genre.value);
// });

// const updateResultCode = (value) => {
//   console.log("Value of genre:", value);
//   switch (value) {
//     case 2:
//       resultCode.value = 2;
//       break;
//     case 1:
//       resultCode.value = 0;
//       break;
//     case 0:
//       resultCode.value = 1;
//       break;
//     default:
//       resultCode.value = 3;
//   }
// };
// watchEffect(() => {
//   switch (genre.value) {
//     case 'All':
//       resultCode.value = 2;
//       console.log("Genre:", genre.value); // Log the current value of genre
//       break;
//     case 'Successful':
//       resultCode.value = 0;
//       console.log("Genre:", genre.value); // Log the current value of genre
//       break;
//     case 'Canceled':
//       resultCode.value = 1;
//       console.log("Genre:", genre.value); // Log the current value of genre
//       break;
//     case 'Incomplete':
//       resultCode.value = 3;
//       console.log("Genre:", genre.value); // Log the current value of genre
//       break;
//     default:
//       resultCode.value = 1; // Default value
//   }
// });
// const genre = ref(2);

// Computed property to execute useQuery whenever genre changes
const { data: payments, isLoading, isError } = computed(() => {
  console.log("Genre changed:", genre.value);
  // Execute useQuery function with the current genre value
  return useQuery("payments", () => {
    console.log("useQuery is invoked");
    console.log(genre.value);
    return paymentStore.fetchPayments(genre.value);
  });
});

// Function to update genre value
const updateResultCode = (newGenre) => {
  console.log("Genre changed:", newGenre);
  genre.value = newGenre;
};
const columns = ref([
  {
    name: "result_desc",
    label: "Result Description",
    align: "left",
    field: "result_desc",
    sortable: true,
  },
  {
    name: "result_code",
    label: "Result Code",
    align: "left",
    field: "result_code",
    sortable: true,
  },
  {
    name: "merchant_request_id",
    label: "Merchant Request ID",
    align: "left",
    field: "merchant_request_id",
    sortable: true,
  },
  {
    name: "checkout_request_id",
    label: "Checkout Request ID",
    align: "left",
    field: "checkout_request_id",
    sortable: true,
  },
  {
    name: "amount",
    label: "Amount",
    align: "right",
    field: "amount",
    sortable: true,
  },
  {
    name: "mpesa_receipt_number",
    label: "Mpesa Receipt Number",
    align: "left",
    field: "mpesa_receipt_number",
    sortable: true,
  },
  {
    name: "transaction_date",
    label: "Transaction Date",
    align: "left",
    field: "transaction_date",
    sortable: true,
  },
  {
    name: "phonenumber",
    label: "Phone Number",
    align: "left",
    field: "phonenumber",
    sortable: true,
  },
  {
    name: "account_number",
    label: "Account Number",
    align: "left",
    field: "account_number",
    sortable: true,
  },
  {
    name: "created_at",
    label: "Created At",
    align: "left",
    field: "created_at",
    sortable: true,
  },
]);
</script>
