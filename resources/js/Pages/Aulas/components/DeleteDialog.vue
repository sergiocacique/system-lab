<template>
  <v-dialog
    v-model="dialog"
    scrollable
    max-width="450"
    transition="dialog-transition"
  >
    <template v-slot:activator="{ on, attrs }">
        <v-btn text icon color="error" v-bind="attrs" v-on="on">
            <v-icon small>mdi-delete</v-icon>
        </v-btn>
      <!-- <v-icon small color="error" v-bind="attrs" v-on="on"> mdi-delete </v-icon> -->
    </template>

    <v-card>
      <v-card-title> Confirmação de exclusão </v-card-title>

      <v-card-text>
        <p>Tem certeza disso ?</p>
      </v-card-text>

      <v-card-actions class="d-flex justify-end">
        <v-btn text color="success" @click="remove()">SIM</v-btn>
        <v-btn text color="error" @click="dialog = false">Não</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    aula_id: Number,
  },

  data: () => ({
    dialog: false,
  }),

  methods: {
    remove() {
      this.$inertia.delete(
        this.$route("dashboard.aulas.destroy", this.aula_id),
        {
          preserveScroll: true,
          onSuccess: () => {
            this.$store.commit("UPDATE_TOAST", { show: true, text: "sucesso" });
          },
        }
      );
    },
  },
};
</script>

<style>
</style>
