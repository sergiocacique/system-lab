<template>
  <div>
    <v-card elevation="0" width="900">
      <v-card-title>
        <Link :href="$route('auth.index')" as="div">
          <v-btn text icon color="primary">
            <v-icon large>mdi-arrow-left</v-icon>
          </v-btn>
        </Link>
        <h1>Cadastrar novo usuário</h1>
      </v-card-title>

      <v-card-text>
        <v-col>
          <v-text-field
            label="Nome completo"
            v-model="user.name_aluno"
            clearable
            :error-messages="errors.name_aluno"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            label="Nome de usuário"
            v-model="user.name"
            clearable
            :error-messages="errors.name"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            label="E-mail"
            type="email"
            v-model="user.email"
            clearable
            :error-messages="errors.email"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            label="Senha"
            type="password"
            v-model="user.password"
            clearable
            :error-messages="errors.password"
          ></v-text-field>
        </v-col>

        <v-col>
          <v-text-field
            label="Confirme sua senha"
            type="password"
            v-model="user.password_confirmation"
            clearable
            :error-messages="errors.password_confirmation"
          ></v-text-field>
        </v-col>
      </v-card-text>

      <v-card-actions class="d-flex justify-center">
        <v-btn color="primary" @click="register()">registrar</v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import LayoutLogin from "../../Layouts/LayoutLogin";

export default {
  layout: LayoutLogin,

  props: {
    errors: Object,
  },

  data: () => ({
    user: {
      name_aluno: null,
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
    },
  }),

  methods: {
    register() {
      this.$inertia.post(this.$route("auth.register"), this.user);
    },
  },
};
</script>

<style>
</style>
