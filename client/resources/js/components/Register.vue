<template>
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6">
      <form @submit.prevent="Register" method="post">
        <div class="input-group mb-3">
          <input type="text" v-model="registerForm.name" class="form-control" placeholder="Nombre Completo" required />
          <div class="input-group-append"></div>
        </div>
        <div class="input-group mb-3">
          <input type="email" v-model="registerForm.email" class="form-control" placeholder="Email" required />
          <div class="input-group-append"></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" v-model="registerForm.password" class="form-control" placeholder="Password" required />
          <div class="input-group-append"></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" v-model="registerForm.confirmPassword" class="form-control" placeholder="Repetir password" required />
          <div class="input-group-append"></div>
        </div>
        <div class="row">
          <div class="col-8">
            <p class="mb-0">
              <router-link to="/login" class="text-center text-decoration-none"
                >Ingresar</router-link
              >
            </p>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">
              Registrarse
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
  name: "register",
  data() {
    return {
      registerForm:{
        name:"",
        email:"",
        password:"",
        confirmPassword:""
      }
    };
  },
  methods: {
    async Register() {
      if(this.registerForm.password === this.registerForm.confirmPassword){
        this.registerForm.name = this.registerForm.name.toLowerCase().trim();
        this.registerForm.email = this.registerForm.email.toLowerCase().trim();
        this.axios.post(api.url + "register", this.registerForm, api.config)
        .then((response) => {
          let DataResponse = response.data;
          if(DataResponse.status == 204){
            Swal.fire('Este email ya existe!', '', 'info');
          }else if(DataResponse.status == 500){
            Swal.fire('Ha ocurrido un error!', '', 'info'); 
          } else{
            this.$router.push({name: "login"});
            Swal.fire('Usuario Registrado Correctamente!', '', 'success');
          }
        })
        .catch(() => {
          Swal.fire('Ha ocurrido un error!', '', 'info');                    
        });
      }else{
        Swal.fire('Estas contraseñas no coinciden!', '', 'info');
      }
    },
  },
};
</script>