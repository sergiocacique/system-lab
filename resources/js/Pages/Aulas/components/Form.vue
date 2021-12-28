<template>
  <div>
    <v-alert v-show="errors.timeCourse" type="error" border="left">
      {{ errors.timeCourse }}
    </v-alert>

    <v-row>
      <v-col>
        <v-text-field
          label="Dia"
          type="date"
          v-model="form.day"
          clearable
          :error-messages="errors.day"
        ></v-text-field>
      </v-col>

      <v-col>
        <v-text-field
          label="Hora de início"
          type="time"
          v-model="form.hour_start"
          clearable
          :error-messages="errors.hour_start"
        ></v-text-field>
      </v-col>

      <v-col>
        <v-text-field
          label="Hora de término"
          type="time"
          min="0"
          v-model="form.hour_end"
          clearable
          :error-messages="errors.hour_end"
        ></v-text-field>
      </v-col>

      <v-col>
        <v-text-field
          label="Quantidade de vagas"
          type="number"
          min="0"
          v-model="form.seat_limit"
          clearable
          :error-messages="errors.seat_limit"
        ></v-text-field>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <v-text-field
          label="Nome"
          type="text"
          v-model="form.name"
          clearable
          :error-messages="errors.name"
        ></v-text-field>
      </v-col>

      <v-col>
        <v-text-field
          label="Professor"
          type="text"
          v-model="form.teacher"
          clearable
          :error-messages="errors.teacher"
        ></v-text-field>
      </v-col>
    </v-row>

    <v-card-actions class="d-flex justify-center">
      <v-btn color="primary" @click="submit">Salvar</v-btn>
    </v-card-actions>
  </div>
</template>

<script>
export default {
  props: {
    aula: Object,
    errors: Object,
  },

  mounted() {
    this.form = this.aula ?? {};
    console.log(this.form, this.aula, this.errors);
  },

  data: () => ({
    form: {},
    alert: false,
    toastSuccess: {
      title: "Sucesso",
      text: "Dado atualizado com sucesso.",
      icon: "success",
      type: "success",
      confirmButtonText: "OK",
    },
    toastError: {
      title: "Erro!",
      text: "Houve um erro de validação",
      icon: "error",
      type: "error",
      confirmButtonText: "OK",
    },
  }),

  watch: {
    alert(value) {
      console.log("clicou alert", value);
      if (!value) {
        this.errors.timeCourse = null;
      }
    },
  },

  methods: {
    submit() {
      if (this.aula?.id) {
        this.$inertia.put(
          this.$route("dashboard.aulas.update", this.aula.id),
          this.form,
          {
            preserveScroll: true,
            onSuccess: () => {
              this.$swal(this.toastSuccess);
            },
            onError: () => {
              this.$swal(this.toastError);
            },
          }
        );
      } else {
        this.$inertia.post(this.$route("dashboard.aulas.store"), this.form, {
          preserveScroll: true,
          onSuccess: () => {
            this.$swal(this.toastSuccess);
          },
          onError: () => {
            this.$swal(this.toastError);
          },
        });
      }
    },
  },
};
</script>

<style>
</style>
