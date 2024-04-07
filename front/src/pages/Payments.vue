<template>
  <div class="q-pa-md">
    <!-- {{ payments }} -->
    <q-table
      title="Payments Records"
      :rows="payments"
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
import { ref } from "vue";
import { usePaymentStore } from "src/stores/payments-store";
import { useQuery } from "vue-query";

const paymentStore = usePaymentStore();

const {
  data: payments,
  isLoading,
  isError,
} = useQuery("payments", () => paymentStore.fetchPayments());
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
