<template>
    <div>
      <q-tabs dense>
        <q-route-tab to="/dashboard" icon="dashboard" label="Dashboard" />
  
        <q-route-tab to="/payments" label="Payments" icon="bubble_chart" />
  
        <q-route-tab
          to="/settings"
          v-if="isAdmin()"
          label="Settings"
          icon="settings"
        />
      </q-tabs>
    </div>
  </template>
  
  <script setup>
  import { useAuthStore } from "src/stores/auth-store";

  const user_store = useAuthStore();
  
  const isAdmin = () =>
    user_store?.user?.user?.roles.some((role) => role["name"] === "Admin");
  </script>
  