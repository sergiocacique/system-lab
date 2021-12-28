<template>
  <div>
    <div class="d-flex align-center">
      <Link :href="$route('dashboard.aulas.index')" as="span">
        <v-btn text icon color="primary" large>
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
      </Link>

      <h1>Editar Aula</h1>
    </div>
    <v-card>
      <v-card-title>
        {{ aula.name }}
      </v-card-title>

      <v-card-text>
        <Form :aula="aula" :errors="errors"/>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import Form from "./components/Form";

export default {
  props: {
    aula: Object,
    errors: Object,
  },

  components: { Form },

  methods: {
    submit() {
      console.log("clicou em salvar");
    },
  },
};
</script>

<style>
</style>
