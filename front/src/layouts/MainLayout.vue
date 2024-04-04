<template>
  <q-layout view="lHh Lpr lFf" class="bg-color">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          v-if="auth_store?.user?.token"
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
          class="menu_button"
        />

        <q-toolbar-title>
          <span class="full_app_name"
            >Payments
            <strong>(<q-icon name="grain" /> PAY)</strong>
            <!-- <img
              class="q-ma-sm"
              src="/logo1.png"
              alt="app log"
              height="50"
              width="80"
            /> -->
          </span>
          <span class="app_name">
            <strong><q-icon name="grain" /> PAY</strong>
            <!-- <img
              class="q-ma-sm"
              src="/logo1.png"
              alt="app log"
              height="50"
              width="80"
            /> -->
          </span>
        </q-toolbar-title>

        <div>
          <span v-if="auth_store?.user?.token">
            <q-btn-dropdown
              icon="power_settings_new"
              size="sm"
              flat
              :label="`${$q.screen.md || $q.screen.lg ? 'User Account' : ''}`"
            >
              <small>
                <div class="row no-wrap q-pa-md">
                  <div class="column">
                    <b>Roles</b>
                    <ol>
                      <li
                        v-for="role in auth_store?.user?.user?.roles"
                        :key="role.uuid"
                      >
                        {{ role.name }}
                      </li>
                    </ol>
                  </div>

                  <q-separator vertical inset class="q-mx-lg" />

                  <div class="column items-center q-pa-0">
                    <q-avatar
                      icon="perm_identity"
                      color="primary"
                      style="font-size: 50px; color: white"
                    />

                    <div class="text-subtitle1 q-mt-md q-mb-xs">
                      {{ auth_store?.user?.user?.name }}
                    </div>

                    <q-btn
                      icon="power_settings_new"
                      size="sm"
                      color="orange"
                      label="Logout"
                      @click="logout"
                      :loading="logoutLoading"
                      unelevated
                    />
                  </div>
                </div>
                <div class="text-center bg-primary text-white">
                  <small>
                    Email:
                    {{
                      auth_store?.user?.user?.email
                        ? auth_store?.user?.user?.email
                        : "N/A"
                    }}
                  </small>
                  <q-separator color="grey" />
                  <!-- <small>
                    Phone:
                    {{
                      auth_store?.user?.user?.phone
                        ? auth_store?.user?.user?.phone
                        : "N/A"
                    }}
                  </small> -->
                  <q-separator color="grey" />
                  <small
                    >Created On: {{ auth_store?.user?.user?.created_at }}</small
                  >
                </div>
              </small>
            </q-btn-dropdown>
          </span>
          <span v-else> Pay v0.0.1 </span>
        </div>
      </q-toolbar>
    </q-header>

    <q-footer reveal v-if="auth_store?.user?.token">
      <BottomLinks />
    </q-footer>

    <q-drawer
      v-if="auth_store?.user?.token"
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      :width="255"
      :breakpoint="767"
    >
      <Links />
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from "vue";
import { useQuasar } from "quasar";
import { useRouter } from "vue-router";

import Links from "src/components/Links.vue";
import { useAuthStore } from "src/stores/auth-store";
import BottomLinks from "src/components/BottomLinks.vue";

const router = useRouter();
const $q = useQuasar();

const auth_store = useAuthStore();

const leftDrawerOpen = ref(false);
const logoutLoading = ref(false);

const toggleLeftDrawer = () => (leftDrawerOpen.value = !leftDrawerOpen.value);

const logout = async () => {
  logoutLoading.value = true;
  const res = await auth_store.logout();
  if (res.status === "success") {
    router.push("/logout_page");
    $q.notify({
      message: "Logged Out Successfully",
      color: "green",
      position: "top",
    });
    logoutLoading.value = false;
    window.location.reload(true);
  }
};
</script>
<style scoped>
.bg-color {
  /* background-color: aliceblue; */
  /* background: rgb(1, 126, 10); */
  background: linear-gradient(
    90deg,
    rgb(213, 246, 223) 0%,
    rgb(165, 240, 255) 100%
  );
}

@media screen and (min-width: 768px) {
  .q-footer {
    display: none;
  }
  .app_name {
    display: none;
  }
}

@media screen and (max-width: 768px) {
  .menu_button {
    display: none;
  }
  .full_app_name {
    display: none;
  }
}
</style>
