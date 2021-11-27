import RedirectIfAuthenticated from "./middlewares/RedirectIfAuthenticatedMiddleware";
import Auth from "./middlewares/AuthMiddleware";

const Users = () => import("./components/Users.vue");
const UsersForm = () => import("./components/UsersForm.vue");
const Login = () => import("./components/Login.vue");
const Register = () => import("./components/Register.vue");

export const routes = [
    {
        name: "users",
        path: "/users",
        component: Users
    },
    {
        name: "**",
        path: "/users",
        component: Users
    },
    {
        name: "create-user",
        path: "/users/create",
        component: UsersForm,
        beforeEnter: Auth
    },
    {
        name: "edit-user",
        path: "/users/:id",
        component: UsersForm,
        beforeEnter: Auth
    },
    {
        name: "login",
        path: "/login",
        component: Login,
        beforeEnter: RedirectIfAuthenticated
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        beforeEnter: RedirectIfAuthenticated
    },
];
