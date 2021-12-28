<template>
  <v-app>
    <v-navigation-drawer app :permanent="!drwaer" :expand-on-hover="!drwaer">
      <!-- profile -->
      <v-list dense>
        <v-list-item class="px-2">
          <v-list-item-avatar>
            <v-img src="https://randomuser.me/api/portraits/men/85.jpg"></v-img>
          </v-list-item-avatar>

          <v-list-item-title>Danilo</v-list-item-title>
        </v-list-item>

        <v-divider></v-divider>
      </v-list>

      <!-- menus -->
      <v-list dense>
        <v-list-item-group v-model="selectedItem" color="secondary">
          <v-list-item v-for="(menu, index) in menus" :key="index" link>
            <Link :href="$route(menu.route)" as="div" class="d-flex">
              <v-list-item-icon>
                <v-icon>{{ menu.icon }}</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ menu.title }}</v-list-item-title>
              </v-list-item-content>
            </Link>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app color="primary">
      <v-app-bar-nav-icon
        @click="drwaer = !drwaer"
        color="white"
      ></v-app-bar-nav-icon>

      <v-toolbar-title class="white--text">System Labs</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-menu offset-y transition="slide-y-transition" bottom class="pa-0">
        <template v-slot:activator="{ on, attrs }">
          <v-btn text v-bind="attrs" v-on="on" dark>
            {{ user.name }}
          </v-btn>
        </template>

        <v-list>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="subtitle-2">
                {{ roles }}
              </v-list-item-title>
              <div class="subtitle-1">
                {{ user.email }}
              </div>
            </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>

          <v-list-item link>
            <v-btn text icon color="green" class="pl-4">
              <v-icon>mdi-account</v-icon>Perfil
            </v-btn>
          </v-list-item>

          <v-list-item @click="logout()">
            <v-btn text icon color="red">
              <v-icon>mdi-logout-variant</v-icon>Sair
            </v-btn>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <v-main class="theme-app">
      <v-container fluid>
        <slot></slot>

        <Toast />
      </v-container>
    </v-main>

    <v-footer app>
      <!-- -->
    </v-footer>
  </v-app>
</template>

<script>
import Toast from "../components/Toast";

export default {
  components: { Toast },

  data: () => ({
    drwaer: false,
    selectedItem: 1,
    menus: [
      {
        icon: "mdi-view-dashboard",
        title: "Dashboard",
        route: "dashboard.index",
      },
      {
        icon: "mdi-school",
        title: "Aulas",
        route: "dashboard.aulas.index",
      },
    ],
  }),

  methods: {
    logout() {
      console.log("clicou em logout");
      this.$inertia.post(this.$route("auth.logout"));
    },
  },
};
</script>

<style>
.theme-app {
  background: #8e9eab;
  background: -webkit-linear-gradient(to right, #eef2f3, #bcc6ce);
  background: linear-gradient(to right, #eef2f3, #bcc6ce);
}
</style>
