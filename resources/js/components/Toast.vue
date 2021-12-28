<template>
  <v-snackbar bottom v-model="toast.show" :color="toast.type">
    {{ toast.text }}

    <template v-slot:action="{ attrs }">
      <v-btn color="white" text v-bind="attrs" @click="close()"> Fechar </v-btn>
    </template>
  </v-snackbar>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters(["toast"]),
  },

  methods: {
    close() {
      const toast = {
        show: false,
        text: "text default",
        type: "success",
        timeout: 2000,
      };
      this.$store.commit("UPDATE_TOAST", toast);
    },
  },
};
</script>

<style>
</style>
