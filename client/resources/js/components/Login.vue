<template>
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6">
      <form @submit.prevent="Login" method="post">
        <div class="input-group mb-3">
          <input type="email" v-model="loginForm.email" class="form-control" placeholder="Email" required />
          <div class="input-group-append"></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" v-model="loginForm.password" class="form-control" placeholder="Password" required />
          <div class="input-group-append"></div>
        </div>
        <div class="row">
          <div class="col-8">
            <p class="mb-0">
              <router-link to="/register" class="text-center text-decoration-none"
                >Registrarse</router-link
              >
            </p>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">
              Ingresar
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-3"></div>
  </div>
</template>
<script>
import * as api from "./api";
import Swal from "sweetalert2";

export default {
  name: "login",
  data() {
    return {
      loginForm:{
        email:"",
        password:""
      }
    };
  },
  methods: {
    Login() {
      this.axios.post(api.url + "login", this.loginForm)
        .then((response) => {
          let DataResponse = response.data;
          if(DataResponse.status == 200){
            localStorage.setItem('auth.token',DataResponse.data.token);
            localStorage.setItem('auth.user',JSON.stringify(DataResponse.data.user));
            window.location.href = 'users';
          }else{
            Swal.fire('Estas credenciales no son validas!', '', 'info');
          }
        })
        .catch(() => {
          Swal.fire('Ha ocurrido un error!', '', 'info');          
        });
    }
  },
};
</script>