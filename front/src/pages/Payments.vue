<template>  
  <div class="q-pa-md">    
    <div>
    <q-btn-toggle
      name="genre"
      v-model="genre"
      push
      glossy
      toggle-color="teal"
      :options="[
        { label: 'All', value: 2 },
        { label: 'Successful', value: 0 },
        { label: 'Canceled', value: 1 },
        { label: 'Incomplete', value: null },
      ]"
    />
    
  </div>
  <div v-if="isLoading">Loading...    
        
      </div>
    <div v-if="error">{{ error }}</div> 
     <!-- <div v-if="genre">
      </div> -->
    <div v-if="genre === 2">
    <q-table
      title="Payments Records"
      :rows=all.payments
      row-key="id"
      :columns="columns"
    >      
    </q-table>
  </div>
  <div v-if="genre === 0">
    <q-table
      title="Payments Records"
      :rows=all.succesful
      row-key="id"
      :columns="columns"
    >      
    </q-table>
  </div>
  <div v-if="genre === 1">
    <q-table
      title="Payments Records"
      :rows=all.unsucccesful
      row-key="id"
      :columns="columns"
    >      
    </q-table>
  </div>
  <div v-if="genre === null">
    <ul>
      <li v-for="message in messages" :key="message.id">{{ message.text }}</li>
    </ul>
    
    <q-table
      title="Payments Records"
      :rows=all.pending
      row-key="id"
      :columns="columns"
    >      
    </q-table>
  </div>

</div>

</template>

<script setup>
import { ref, computed, watchEffect } from "vue";
import { usePaymentStore } from "src/stores/payments-store";
const paymentStore = usePaymentStore();
import { useQuery } from "vue-query";
const { data: all, isLoading: isLoading, error: error, refetch: refetch } = useQuery("payments", paymentStore.fetchAllPayments);
const messages = ref([]);

// Listen for 'message' event from Socket.IO server
$socket.on('message', (data) => {
  // Handle event data by adding to messages array
  messages.value.push(data);
});

const genre = ref(2);
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
