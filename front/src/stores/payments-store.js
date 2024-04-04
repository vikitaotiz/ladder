import { defineStore } from "pinia";
import {
    post_call,
    post_call_logout,
  } from "src/utilities/api_calls/post_calls";
  import { storedUser } from "src/utilities/stored_user";
  
export const paymentStore = defineStore("payments", {
    state: () => ({
      payments: [],
    }),

    getters: {

    }
})  