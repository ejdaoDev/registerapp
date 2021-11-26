<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombres</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.role }}</td>
                <td>
                  <button
                    class="btn btn-outline-danger"
                    @click="DeleteUsers(user.id)"
                  >
                    <i class="far fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import * as api from "./api";
import Swal from "sweetalert2";

export default {
  name: "users",
  data() {
    return {
      users: [],
    };
  },
  mounted() {
    this.ShowUsers();
  },
  methods: {
    async ShowUsers() {
      await this.axios
        .get(api.url + "user", api.config)
        .then((response) => {
          let DataResponse = response.data;
          this.users = DataResponse.data.users;
        })
        .catch(() => {
          this.users = [];
        });
    },
    async DeleteUsers(id) {
      if (localStorage.getItem("auth.token") != null) {
        Swal.fire({
          title: "Seguro quieres eliminar este usuario?",
          showDenyButton: true,
          showCancelButton: true,
          showConfirmButton: false,
          denyButtonText: "Eliminar",
          cancelButtonText: `Cancelar`,
        }).then((result) => {
          if (result.isDenied) {
            this.axios
              .delete(api.url + "user/" + id, api.config)
              .then((response) => {
                let DataResponse = response.data;
                if(DataResponse.status == 200){
                  Swal.fire(
                  "El usuario fue borrado correctamente!",
                  "",
                  "success"
                );
                setTimeout(function(){ window.location.reload() }, 500);
                }else{
                  Swal.fire("Su sesión ha finalizado!", "", "info");
                }
              })
              .catch(() => {
                Swal.fire("Ha ocurrido un error!", "", "info");
              });
          }
        });
      } else {
        Swal.fire(
          "Debe estar autenticado para acceder a estas funciones!",
          "",
          "info"
        );
      }
    },
  },
};
</script>