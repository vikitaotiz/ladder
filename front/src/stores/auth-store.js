import { defineStore } from "pinia";
import {
  post_call,
  post_call_logout,
} from "src/utilities/api_calls/post_calls";
import { storedUser } from "src/utilities/stored_user";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: storedUser(),
  }),

  actions: {
    saveUser(data) {
      localStorage.setItem("auth_user", JSON.stringify(data));
    },

    removeUser() {
      localStorage.removeItem("auth_user");
    },

    async login(payload) {
      const res = await post_call(payload, "login");
      this.saveUser(res);
      this.user = res;
      return res;
    },

    async register(payload) {
      const res = await post_call(payload, "register");
      this.saveUser(res);
      this.user = res;
      return res;
    },

    async logout() {
      if (this.user?.token) {
        const res = await post_call_logout("logout", this.user?.token);
        if (res.status === "success") {
          this.user = null;
          this.removeUser();
          return res;
        }
      } else {
        alert("Logout. There was an error");
      }
    },
  },
});
