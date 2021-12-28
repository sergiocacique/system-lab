<template>
  <v-dialog
    v-model="dialog"
    scrollable
    max-width="800"
    transition="dialog-transition"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn text icon color="secondary" v-bind="attrs" v-on="on">
        <v-icon small>mdi-account-details-outline</v-icon>
      </v-btn>
    </template>

    <v-card>
      <v-card-title> Detalhes </v-card-title>
      <v-card-subtitle>
        <div class="d-flex flex-column">
          <span><b>Data:</b> {{ aula.day | formatDate }}</span>
          <span><b>Hora:</b> {{ aula.hour }}</span>
          <span><b>Nome da aula:</b> {{ aula.name }}</span>
          <span>
            <b> Quantidade de Check-in:</b>
            {{ aula.students_checkin.length }}
          </span>
        </div>
      </v-card-subtitle>

      <v-card-text>
        <v-list>
          <v-subheader>ALUNOS QUE FIZERAM CHECK IN</v-subheader>
          <v-list-item
            link
            v-for="(aluno, index) in aula.students_checkin"
            :key="index"
          >
            <v-list-item-content>
              <v-list-item-title v-text="aluno.name"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card-text>

      <v-card-actions class="d-flex justify-end">
        <v-btn text color="primary" @click="dialog = false">Sair</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    aula: Object,
  },

  data: () => ({
    dialog: false,
  }),
};
</script>

<style>
</style>
