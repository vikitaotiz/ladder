<template>
  <div>
    <q-list>
      <q-item-label header class="text-center"> Menu </q-item-label>
      <q-separator color="primary" />

      <q-item clickable to="/dashboard">
        <q-item-section avatar>
          <q-icon name="dashboard" />
        </q-item-section>

        <q-item-section>
          <q-item-label>Dashboard</q-item-label>
          <q-item-label caption><small>App Reports</small></q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />

      <q-item clickable to="/payments">
        <q-item-section avatar>
          <q-icon name="dashboard" />
        </q-item-section>

        <q-item-section>
          <q-item-label>Payments</q-item-label>
          <q-item-label caption><small>App Reports</small></q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />

      <q-item clickable to="/settings" v-if="isAdmin()">
        <q-item-section avatar>
          <q-icon name="dashboard" />
        </q-item-section>
        

        <q-item-section>
          <q-item-label>Settings</q-item-label>
          <q-item-label caption><small>App Settings</small></q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
  </div>
</template>

<script setup>
import { useAuthStore } from "src/stores/auth-store";

import { hasPermission } from "src/utilities/helpers";
const user_store = useAuthStore();

const isAdmin = () =>
  user_store?.user?.user?.roles.some((role) => role["name"] === "Admin");
</script>
<style scoped>
.heavy {
  font-weight: 700;
}
</style>