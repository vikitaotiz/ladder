<template>
  <q-page class="flex flex-center">
    <div class="q-gutter-y-md" style="width: 60%">
      <q-card bordered>
        <q-tabs
          v-model="tab"
          dense
          class="text-grey"
          active-color="primary"
          indicator-color="primary"
          align="justify"
          narrow-indicator
        >
          <q-tab name="login" label="Login" />
          <q-tab name="register" label="Register" />
        </q-tabs>
        <q-separator />

        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="login">
            <q-input
              dense
              outlined
              type="email"
              label="Email"
              v-model="formData.email"
              class="q-mb-sm"
            />
            <q-input
              dense
              outlined
              type="password"
              label="Password"
              v-model="formData.password"
              class="q-mb-sm"
            />

            <small style="color: red">{{ errorMsg }}</small>

            <q-btn
              icon="mail"
              dense
              label="Login"
              dark
              color="primary"
              @click="login"
              class="full-width"
              :loading="loadLogin"
              rounded
            />
          </q-tab-panel>

          <q-tab-panel name="register">
            <q-input
              dense
              outlined
              type="text"
              label="Name"
              v-model="formData.name"
              class="q-mb-sm"
            />
            <q-input
              dense
              outlined
              type="email"
              label="Email"
              v-model="formData.email"
              class="q-mb-sm"
            />
            <q-input
              dense
              outlined
              type="password"
              label="Password"
              v-model="formData.password"
              class="q-mb-sm"
            />

            <small style="color: red">{{ errorMsg }}</small>

            <q-btn
              icon="mail"
              dense
              label="Register"
              dark
              color="primary"
              @click="register"
              rounded
              class="full-width"
            />
          </q-tab-panel>
        </q-tab-panels>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useAuthStore } from "src/stores/auth-store";
import { useQuasar } from "quasar";
import { useRouter } from "vue-router";

const tab = ref("login");
const loadLogin = ref(false);
const errorMsg = ref("");

const quasarPlugins = useQuasar();
const router = useRouter();
const user_store = useAuthStore();

// Form data
const formData = reactive({
  name: "",
  email: "",
  password: "",
});

// // Methods
// // Login
const login = async () => {
  const userLogin = {
    email: formData.email.trim(),
    password: formData.password.trim(),
  };

  if (userLogin.email && userLogin.password) {
    loadLogin.value = true;
    const res = await user_store.login(userLogin);

    if (res.status === "success") redirectUser(res.message, "green");
    else displayErrorMsg(res.message);
  } else notifyMsg("Email and password are required", "red");
};

// // Register
const register = async () => {
  const userRegister = {
    name: formData.name.trim(),
    email: formData.email.trim(),
    password: formData.password.trim(),
  };

  if (userRegister.name && userRegister.email && userRegister.password) {
    loadLogin.value = true;
    // const res = await user_store.login(userLogin);
    const res = await user_store.login(userRegister);

    if (res.status === "success") redirectUser(res.message, "green");
    else displayErrorMsg(res.message);
  } else notifyMsg("Name, Email and password are required", "red");
};

const notifyMsg = (message, color) => {
  quasarPlugins.notify({
    message,
    color,
    position: "top",
  });
};

const displayErrorMsg = (message) => {
  errorMsg.value = message;
  notifyMsg(message, "red");
  setTimeout(() => (errorMsg.value = ""), 10000);
};

const redirectUser = (message, color) => {
  loadLogin.value = false;
  notifyMsg(message, color);
  router.push("/dashboard");
};
</script>