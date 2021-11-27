<template>
  <div class="row">
    <div class="col-2"></div>
    <div class="col-8">
      <div class="card">
        <div class="card-header">
          <h6 class="font-weight-bold text-primary" v-if="create">
            Crear Usuario
          </h6>
          <h6 class="font-weight-bold text-primary" v-if="edit">
            Editar Usuario
          </h6>
        </div>
        <form @submit.prevent="User" method="post">
          <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input
              type="text"
              placeholder="Nombre"
              v-model="UserForm.name"
              class="form-control"
              required
            />
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input
              type="email"
              placeholder="Email"
              v-model="UserForm.email"
              class="form-control"
              required
            />
          </div>
          <div class="mb-3">
            <label class="form-label">rol</label>
            <select v-model="UserForm.role" class="form-control" required>
              <option
                selected
                disabled
                hidden
                style="display: none"
                value=""
              ></option>
              <option value="ADMIN">ADMIN</option>
              <option value="USER">USER</option>
            </select>
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-primary" v-if="create">
              Crear
            </button>
            <button type="submit" class="btn btn-success" v-if="edit">
              Actualizar
            </button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
            <router-link
              to="/users"
              type="button"
              class="btn btn-secondary"
              style="float: right"
              ><i class="fas fa-backward"></i>{{ " " }}Volver</router-link
            >
          </div>
        </form>
      </div>
    </div>
    <div class="col-2"></div>
  </div>
</template>
<script>
import * as api from "./api";
import Swal from "sweetalert2";

export default {
  name: "users",
  data() {
    return {
      create: false,
      edit: true,
      UserForm: {
        name: "",
        email: "",
        role: "",
      },
    };
  },
  mounted() {
    if (window.location.href.includes("create")) {
      this.create = true;
      this.edit = false;
    }
    if (this.edit) {
      this.axios
        .get(api.url + "user/get-user/" + this.$route.params.id, api.config)
        .then((response) => {
          let DataResponse = response.data;
          if (DataResponse.status == 200) {
            this.UserForm.name = DataResponse.data.user.name;
            this.UserForm.email = DataResponse.data.user.email;
            this.UserForm.role = DataResponse.data.user.role;
          } else {
            Swal.fire("No Found", "", "info");
          }
        })
        .catch(() => {
          Swal.fire("No Found", "", "info");
          setTimeout(function () {
            window.location.href = "/users";
          }, 500);
        });
    }
  },
  methods: {
    async User() {
      this.UserForm.name = this.UserForm.name.toLowerCase().trim();
      this.UserForm.email = this.UserForm.email.toLowerCase().trim();
      if (this.create) {
        this.axios
          .post(api.url + "user", this.UserForm, api.config)
          .then((response) => {
            let DataResponse = response.data;
            if (DataResponse.status == 204) {
              Swal.fire("Este email ya existe!", "", "info");
            } else if (DataResponse.status == 500) {
              Swal.fire("Ha ocurrido un error!", "", "info");
            } else {
              Swal.fire("Usuario Creado Correctamente!", "", "success");
              this.UserForm.name = "";
              this.UserForm.email = "";
              this.UserForm.role = "";
            }
          })
          .catch(() => {
            Swal.fire("Ha ocurrido un error!", "", "info");
          });
      } else {
        this.axios
          .put(
            api.url + "user/" + this.$route.params.id,
            this.UserForm,
            api.config
          )
          .then((response) => {
            let DataResponse = response.data;
            if (DataResponse.status == 204) {
              Swal.fire("Este email ya existe!", "", "info");
            } else if (DataResponse.status == 200) {
              this.$router.push({name: "users"});
            }
          })
          .catch(() => {
            Swal.fire("Ha ocurrido un error!", "", "info");
          });
        console.log(this.$route.params);
      }
    },
  },
};
</script>
<style>
.mb-3 {
  margin-right: 10px !important;
  margin-left: 10px !important;
}
</style>