import { defineStore } from "pinia";
import {
  get_call_module,
} from "src/utilities/api_calls/module_calls";
import { storedUser } from "src/utilities/stored_user";

const user = storedUser();
const token = user?.token;

export const usePaymentStore = defineStore("payments", {
  state: () => ({
    payments: [],
  }),

  actions: {
    async fetchPayments() {
      if (token) {
        const res = await get_call_module("payments", token);
        this.payments = res?.data;
        console.log("rtyu ", res);
        return this.payments;
      }
    },
  },
});
