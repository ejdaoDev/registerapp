<template>
    <div class="row">
        <div class="col-12">
            <router-link
                to="/users/create"
                type="button"
                class="btn btn-success option-button"
                v-if="auth"
            >
                <i class="fas fa-user-plus"></i>
            </router-link>
            <button
                class="btn btn-success option-button"
                v-if="auth && removed"
                @click="Filter('not removed')"
            >
                Ver Usuarios Existentes
            </button>
            <button
                class="btn btn-primary option-button"
                v-if="auth && removed"
                @click="RestoreAllUsers()"
            >
                Restaurar Todos
            </button>
            <button
                class="btn btn-danger option-button"
                v-if="auth && !removed"
                @click="Filter('removed')"
            >
                Ver Usuarios Eliminados
            </button>

            <div class="card">
                <div class="card-header py-3">
                    <h6
                        class="m-0 font-weight-bold text-primary"
                        v-if="!auth || (auth && !removed)"
                    >
                        Usuarios (Activos)
                    </h6>
                    <h6
                        class="m-0 font-weight-bold text-primary"
                        v-if="auth && removed"
                    >
                        Usuarios (Eliminados)
                    </h6>
                </div>
                <div class="card-body">
                    <!--Empieza el paginador-->
                    <ul class="pagination float-right">
                        <li class="page-item">
                            <a
                                class="page-link"
                                href="#"
                                @click="getUsers(pagination.first_page_url)"
                                ><i class="fas fa-step-backward"></i
                            ></a>
                        </li>
                        <li
                            v-if="pagination.current_page == 1"
                            class="page-item disabled"
                        >
                            <a class="page-link" href="#" tabindex="-1"
                                ><i class="fas fa-chevron-circle-left"></i
                            ></a>
                        </li>
                        <li v-else class="page-item">
                            <a
                                class="page-link"
                                href="#"
                                tabindex="-1"
                                @click="getUsers(pagination.prev_page_url)"
                                ><i class="fas fa-chevron-circle-left"></i
                            ></a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#"
                                >Pag. {{ pagination.current_page }} de
                                {{ pagination.last_page }}</a
                            >
                        </li>
                        <li v-if="pagination.current_page == pagination.last_page"
                            class="page-item disabled" >
                            <a class="page-link" href="#"
                                ><i class="fas fa-chevron-circle-right"></i
                            ></a>
                        </li>
                        <li v-else class="page-item">
                            <a
                                class="page-link"
                                href="#"
                                @click="getUsers(pagination.next_page_url)"
                                ><i class="fas fa-chevron-circle-right"></i
                            ></a>
                        </li>
                        <li class="page-item">
                            <a
                                class="page-link"
                                href="#"
                                @click="getUsers(pagination.last_page_url)"
                                ><i class="fas fa-step-forward"></i
                            ></a>
                        </li>
                    </ul>
                    <!--Termina el paginador-->
                    <table
                        id="datatable"
                        class="table table-bordered table-striped"
                    >
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
                                        @click="DeleteUser(user.id)"
                                        v-if="!auth || (auth && !removed)"
                                    >
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button
                                        class="btn btn-outline-success"
                                        @click="EditUser(user.id)"
                                        v-if="auth && !removed"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button
                                        class="btn btn-outline-primary"
                                        @click="RestoreUser(user.id)"
                                        v-if="auth && removed"
                                    >
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                    <button
                                        class="btn btn-outline-danger"
                                        @click="HardDeleteUser(user.id)"
                                        v-if="auth && removed"
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
            auth: false,
            removed: false,
            users: [],
            pagination: {
                prev_page_url: null,
                first_page_url: null,
                next_page_url: null,
                last_page_url: null,
                current_page: null,
                last_page: null
            }
        };
    },
    mounted() {
        this.ShowUsers();
        if (localStorage.getItem("auth.token") != null) {
            this.auth = true;
        }
    },
    methods: {
        async getUsers(url) {
            await this.axios
                .get(url, api.config)
                .then(response => {
                    let DataResponse = response.data;
                    this.users = DataResponse.data.users.data;
                    this.pagination.current_page =
                        DataResponse.data.users.current_page;
                    this.pagination.last_page =
                        DataResponse.data.users.last_page;
                    this.pagination.next_page_url =
                        DataResponse.data.users.next_page_url;
                    this.pagination.prev_page_url =
                        DataResponse.data.users.prev_page_url;
                    this.pagination.last_page_url =
                        DataResponse.data.users.last_page_url;
                })
                .catch(() => {
                    this.users = [];
                });
        },
        async ShowUsers() {
            await this.axios
                .get(api.url + "user", api.config)
                .then(response => {
                    let DataResponse = response.data;
                    this.users = DataResponse.data.users.data;
                    this.pagination.current_page =
                        DataResponse.data.users.current_page;
                    this.pagination.last_page =
                        DataResponse.data.users.last_page;
                    this.pagination.next_page_url =
                        DataResponse.data.users.next_page_url;
                    this.pagination.first_page_url =
                        DataResponse.data.users.first_page_url;
                    this.pagination.last_page_url =
                        DataResponse.data.users.last_page_url;
                })
                .catch(() => {
                    this.users = [];
                });
        },
        async Filter(key) {
            if (key == "removed") {
                await this.axios
                    .get(api.url + "user/get-deleted-users", api.config)
                    .then(response => {
                        let DataResponse = response.data;
                        this.users = DataResponse.data.users.data;
                        this.pagination.current_page =
                            DataResponse.data.users.current_page;
                        this.pagination.last_page =
                            DataResponse.data.users.last_page;
                        this.pagination.next_page_url =
                            DataResponse.data.users.next_page_url;
                        this.pagination.first_page_url =
                            DataResponse.data.users.first_page_url;
                        this.pagination.last_page_url =
                            DataResponse.data.users.last_page_url;
                    })
                    .catch(() => {
                        this.users = [];
                    });
                this.removed = true;
            } else {
                this.ShowUsers();
                this.removed = false;
            }
        },
        async DeleteUser(id) {
            if (localStorage.getItem("auth.token") != null) {
                Swal.fire({
                    title: "Seguro quieres eliminar este usuario?",
                    showDenyButton: true,
                    showCancelButton: true,
                    showConfirmButton: false,
                    denyButtonText: "Eliminar",
                    cancelButtonText: `Cancelar`
                }).then(result => {
                    if (result.isDenied) {
                        this.axios
                            .delete(api.url + "user/" + id, api.config)
                            .then(response => {
                                let DataResponse = response.data;
                                if (DataResponse.status == 200) {
                                    Swal.fire(
                                        "El usuario fue borrado correctamente!",
                                        "",
                                        "success"
                                    );
                                    this.ShowUsers();
                                } else {
                                    Swal.fire(
                                        "Su sesión ha finalizado!",
                                        "",
                                        "info"
                                    );
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
        async EditUser(id) {
            this.$router.push({
                name: "edit-user",
                params: {
                    id: id
                }
            });
        },
        async RestoreUser(id) {
            if (localStorage.getItem("auth.token") != null) {
                Swal.fire({
                    title: "Seguro quieres restaurar este usuario?",
                    showDenyButton: false,
                    showCancelButton: true,
                    showConfirmButton: true,
                    confirmButtonText: "Restaurar",
                    cancelButtonText: `Cancelar`
                }).then(result => {
                    if (result.isConfirmed) {
                        this.axios
                            .get(
                                api.url + "user/restore-user/" + id,
                                api.config
                            )
                            .then(response => {
                                let DataResponse = response.data;
                                if (DataResponse.status == 200) {
                                    Swal.fire(
                                        "El usuario fue restaurado correctamente!",
                                        "",
                                        "success"
                                    );
                                    this.Filter("removed");
                                } else {
                                    Swal.fire(
                                        "Su sesión ha finalizado!",
                                        "",
                                        "info"
                                    );
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
        async RestoreAllUsers() {
            console.log(this.users.length);
            if (
                localStorage.getItem("auth.token") != null &&
                this.users.length != 0
            ) {
                Swal.fire({
                    title: "Seguro quieres restaurar todos los usuarios?",
                    showDenyButton: false,
                    showCancelButton: true,
                    showConfirmButton: true,
                    confirmButtonText: "Restaurar",
                    cancelButtonText: `Cancelar`
                }).then(result => {
                    if (result.isConfirmed) {
                        this.axios
                            .get(api.url + "user/restore-all-users", api.config)
                            .then(response => {
                                let DataResponse = response.data;
                                if (DataResponse.status == 200) {
                                    Swal.fire(
                                        "Los usuarios fueron restaurados correctamente!",
                                        "",
                                        "success"
                                    );
                                    this.Filter("removed");
                                } else {
                                    Swal.fire(
                                        "Su sesión ha finalizado!",
                                        "",
                                        "info"
                                    );
                                }
                            })
                            .catch(() => {
                                Swal.fire("Ha ocurrido un error!", "", "info");
                            });
                    }
                });
            } else {
                Swal.fire("No hay usuarios que restaurar!", "", "info");
            }
        },
        async HardDeleteUser(id) {
            if (localStorage.getItem("auth.token") != null) {
                Swal.fire({
                    title:
                        "Seguro quieres eliminar DEFINITIVAMENTE este usuario?",
                    showDenyButton: true,
                    showCancelButton: true,
                    showConfirmButton: false,
                    denyButtonText: "Eliminar",
                    cancelButtonText: `Cancelar`
                }).then(result => {
                    if (result.isDenied) {
                        this.axios
                            .delete(
                                api.url + "user/force-delete/" + id,
                                api.config
                            )
                            .then(response => {
                                let DataResponse = response.data;
                                if (DataResponse.status == 200) {
                                    Swal.fire(
                                        "El usuario fue borrado definitivamente!",
                                        "",
                                        "success"
                                    );
                                    this.Filter("removed");
                                } else {
                                    Swal.fire(
                                        "Su sesión ha finalizado!",
                                        "",
                                        "info"
                                    );
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
        }
    }
};
</script>
<style>
.option-button {
    margin-bottom: 5px;
    margin-right: 3px;
}
</style>
