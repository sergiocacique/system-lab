<template>
  <div>
    <h1>Aulas</h1>

    <v-card>
      <v-card-title>
        <v-row class="d-flex justify-space-around align-baseline">
          <v-col cols="9">
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Buscar"
              single-line
              hide-details
              clearable
            ></v-text-field>
          </v-col>

          <v-col v-if="canRole(roles)">
            <Link as="div" :href="$route('dashboard.aulas.create')">
              <v-btn color="primary">Novo</v-btn>
            </Link>
          </v-col>

          <v-col>
            <v-select
              :items="filters"
              v-model="filter"
              @change="filtred()"
              label="Filtrar por"
            ></v-select>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <v-data-table :headers="computedHeader" :items="aulas" :search="search">
          <template v-slot:[`item.day`]="{ item }">
            {{ item.day | formatDate }}
          </template>

          <template v-slot:[`item.actions`]="{ item }">
            <div class="d-flex justify-space-around">
              <DeleteDialog :aula_id="item.id" v-if="canRole(roles)" />

              <Link
                as="span"
                :href="$route('dashboard.aulas.edit', item.id)"
                v-if="canRole(roles)"
              >
                <v-btn text icon color="primary">
                  <v-icon small> mdi-pencil </v-icon>
                </v-btn>
              </Link>
              <DetailDialog :aula="item" v-if="canRole(roles)" />
              <v-switch
                v-model="item.checkin_pivot"
                :label="item.checkin_pivot ? 'Check In' : 'Check Out'"
                @change="checkin(item)"
                :disabled="item.checkable"
                v-if="!canRole(roles)"
              ></v-switch>
            </div>
          </template>
          <template v-slot:no-data>
            <div>Nenhum dado encontrado</div>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import DeleteDialog from "./components/DeleteDialog";
import DetailDialog from "./components/DetailDialog";

export default {
  props: {
    aulas: Array,
    errors: Object,
    filterInit: String,
  },

  mounted() {
    this.filter = this.filterInit;
    console.log(this.aulas)
  },

  components: { DeleteDialog, DetailDialog },

  data() {
    return {
      search: "",
      filters: ["Todos", "Semana", "Dia"],
      filter: "Todos",
      headers: [
        { text: "Dia", value: "day", align: "start" },
        { text: "Hora", value: "hour_start", align: "start" },
        {
          text: "Nome",
          value: "name",
          align: "start",
          sortable: true,
        },
        { text: "Nome do Professor", value: "teacher", align: "start" },
        { text: "Limite de vagas", value: "seat_limit", align: "start" },
        { text: "Check in", value: "checkin_count", align: "start" },
        { text: "Ação", value: "actions", align: "start", sortable: false },
      ],
    };
  },

  computed: {
    roles() {
      return this.$page.props.auth.roles.map((r) => r.name);
    },

    computedHeader() {
      return this.headers.filter((h) => {
        if (!this.canRole(this.roles)) {
          return h.value !== "checkin" && h.value !== "teacher";
        }
        return h;
      });
    },
  },

  methods: {
    checkin(aula) {
      const message = "realizado com sucesso.";
      this.$inertia.post(
        this.$route("dashboard.aulas.checkin"),
        {
          aula: aula,
        },
        {
          preserveScroll: true,
          onSuccess: () => {
            this.$swal({
              title: "Sucesso",
              text: aula.checkin_pivot
                ? "Check In " + message
                : "Check Out " + message,
              icon: "success",
              type: "success",
              confirmButtonText: "OK",
            });
          },
          onError: (error) => {
            const message = "O servidor detectou algum erro";

            this.$swal({
              title: "Erro!",
              text: error.seat_limit ?? message,
              icon: "error",
              type: "error",
              confirmButtonText: "OK",
            });
          },
        }
      );
    },

    filtred() {
      this.$inertia.visit(this.$route("dashboard.aulas.index"), {
        method: "get",
        preserveScroll: true,
        data: {
          filter: this.filter,
        },
      });
    },
  },
};
</script>
