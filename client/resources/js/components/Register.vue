<template>
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6">
      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nombre Completo" />
          <div class="input-group-append"></div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" />
          <div class="input-group-append"></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" />
          <div class="input-group-append"></div>
        </div>
        <div class="input-group mb-3">
          <input
            type="password"
            class="form-control"
            placeholder="Repetir password"
          />
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
          <!-- /.col -->
          <div class="col-4">
            <button type="button" class="btn btn-primary btn-block">
              Registrarse
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <div class="col-3"></div>
  </div>
</template>