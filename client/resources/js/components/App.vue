<template>
  <main>
    <nav
      class="navbar navbar-expand navbar-dark bg-primary"
      style="box-shadow: 0px 4px 4px gray"
    >
      <div class="container-fluid">
        <router-link class="navbar-brand" to="/">
          <img
            src="https://vuejs.org/images/logo.svg"
            alt=""
            width="30"
            height="24"
          />Home
        </router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link
                exact-active-class="active"
                to="/users"
                class="nav-link"
                aria-current="page"
                >Usuarios</router-link
              >
            </li>
          </ul>
          <div class="d-flex">
            <router-link
              to="/login"
              class="btn btn-success"
              v-if="!auth"
              type="button"
              >Login</router-link
            >
            <button
              @click="Logout()"
              class="btn btn-danger"
              v-if="auth"
              type="button"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>
    <div class="container mt-5">
      <router-view></router-view>
    </div>
  </main>
</template>
 
<script>
import * as api from "./api";
import Swal from "sweetalert2";
export default {
  data() {
    return {
      auth: false,
    };
  },
  mounted() {
    if (localStorage.getItem("auth.token") != null) {
      this.auth = true;
    }
  },
  methods: {
    Logout() {
      Swal.fire({
        title: "Seguro quieres cerrar sesión?",
        showDenyButton: true,
        showCancelButton: true,
        showConfirmButton: false,
        denyButtonText: "Seguro",
        cancelButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isDenied) {
          this.axios
            .get(api.url + "logout", api.config)
            .then(() => {
              localStorage.clear();
              window.location.reload();
            })
            .catch(() => {
              localStorage.clear();
              window.location.reload();
            });
        }
      });
    },
  },
};
</script>