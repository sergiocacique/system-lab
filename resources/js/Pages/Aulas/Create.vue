<template>
  <div>
   <div class="d-flex align-center">
      <Link :href="$route('dashboard.aulas.index')" as="span">
        <v-btn text icon color="primary" large>
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
      </Link>

      <h1>Nova Aula</h1>
    </div>

    <v-card>
      <v-card-text>
        <Form :errors="errors" />
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import Form from "./components/Form";

export default {
  props: {
    errors: Object,
  },

  components: { Form },
};
</script>

<style>
</style>
