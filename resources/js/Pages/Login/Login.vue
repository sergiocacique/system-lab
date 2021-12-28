<template>
  <v-card width="100%" class="py-5" elevation="0">
    <v-list-item three-line>
      <v-list-item-content class="text-center">
        <v-list-item-title class="text-h5 mb-1 text-uppercase">
          Bem Vindo
        </v-list-item-title>
        <v-list-item-subtitle>
          Preencha os campos abaixo para entrar
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <div class="d-flex align-center">
      <v-card-text>
        <v-card-text>
          <v-form>
            <ul>
              <li
                v-for="(error, index) in Object.values(errors)"
                :key="index"
                class="subtitle-1 error--text"
              >
                {{ error }}
              </li>
            </ul>

            <v-text-field
              name="email"
              label="E-mail"
              type="text"
              v-model="credentials.email"
              clearable
            ></v-text-field>
            <v-text-field
              name="password"
              label="Senha"
              type="password"
              v-model="credentials.password"
              clearable
            ></v-text-field>
          </v-form>
        </v-card-text>

        <v-card-actions class="d-flex justify-space-between">
          <v-checkbox v-model="checkbox" label="Lembrar-me"></v-checkbox>

          <div>Esqueceu a senha ou e-mail?</div>
        </v-card-actions>

        <v-card-actions class="d-flex justify-space-between">
          <Link :href="$route('auth.create')" as="div">
            <v-btn color="primary" outlined rounded dark medium>
              Registrar
            </v-btn>
          </Link>
          <v-btn color="primary" outlined rounded dark medium @click="login()">
            Entrar
          </v-btn>
        </v-card-actions>
      </v-card-text>

      <v-divider vertical class="mx-2" height="50"></v-divider>

      <v-card-text :style="isMobile ? 'width: 200px' : ''">
        <v-card-text class="d-flex justify-center">
          <img
            src="img/login_mobile.png"
            :height="!isMobile ? 500 : 200"
            :width="!isMobile ? 500 : 200"
            alt="image login"
          />
        </v-card-text>
      </v-card-text>
    </div>
  </v-card>
</template>

<script>
import LayoutLogin from "../../Layouts/LayoutLogin";

export default {
  props: {
    errors: Object,
  },

  data: () => ({
    checkbox: false,
    credentials: {
      email: "danilovsdanilo@gmail.com",
      password: "danilo123",
    },
  }),

  layout: LayoutLogin,

  methods: {
    login() {
      console.log("clicou em login");
      this.$inertia.post(this.$route("auth.login"), this.credentials);
    },
  },
};
</script>

<style>
</style>
