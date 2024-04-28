import { defineStore } from "pinia";
import {
  get_call_module,
} from "src/utilities/api_calls/module_calls";
import { storedUser } from "src/utilities/stored_user";

const user = storedUser();
const token = user?.token;
export const usePaymentStore = defineStore("payments", {
  state: () => ({
    all: [],
    unsuccPayments: [],
    succPayments: [],
    pendingPayments: [],
    amount: [],
    codeResponse: [],
    sevenDaypayments: [],
  }),

  actions: {
    async fetchAllPayments() {
      if (token) {
        const res = await get_call_module("payments", token);
        this.all = res?.all;
        this.amount = res?.all.map(item =>  parseFloat(item.amount));
                this.pendingPayments = res?.pendingPayments;
                this.unsuccPayments = res?.unsuccPayments;
                this.succPayments = res?.succPayments;
                this.codeResponse = res?.resultCodes;
                this.sevenDaypayments = res?.sevenDaypayments;
                console.log("this pp",res );

        return {
          payments: this.all,
          amounts: this.amount,
          unsucccesful: this.unsuccPayments,
          succesful: this.succPayments,
          pending: this.pendingPayments,
          codeResult: this.codeResponse,
          sevenDaypay: this.sevenDaypayments
        };
      }
      else {
                console.log("token error");
              }
    },
  },  
});
