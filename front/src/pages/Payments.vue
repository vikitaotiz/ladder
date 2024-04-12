<template>
  <div class="q-pa-md">
    <!-- {{ payments }} -->
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
    />
    <q-table
      title="Payments Records"
      :rows="currentItems"
      row-key="id"
      :columns="columns"
    >
    <template #top-right>
        <q-btn
          v-if="isLoading"
          color="primary"
          label="Loading..."
          loading
        />
      </template>
    </q-table>
  </div>
</template>

<script setup>
import { ref, computed, watchEffect } from "vue";
import { usePaymentStore } from "src/stores/payments-store";
import { useQuery } from "vue-query";

const paymentStore = usePaymentStore();

// Function to fetch data for a key
async function fetchData(key) {
  return paymentStore.fetchPayments(key);
}

// Object to store fetched data
const dataMap = ref({});
const genre = ref(2); 

// UseQuery hook to fetch initial data
const { data: initialItems, isLoading, isError } = useQuery(
  ['payments', genre.value], // Use the initial genre value in the query key
  () => fetchData(genre.value)
);

// Store the initial data in dataMap
dataMap.value[genre.value] = initialItems;

// Computed property to get the current data based on the selected genre
const currentItems = computed(() => dataMap.value[genre.value]);

watchEffect(() => {
  const newGenre = genre.value;
  // Fetch data for the new genre
  fetchData(newGenre).then(items => {
    // Update the dataMap with the fetched data
    dataMap.value[newGenre] = items;
  }).catch(error => {
    console.error('Error fetching data:', error);
  });
});
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
