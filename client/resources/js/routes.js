import RedirectIfAuthenticated from "./middlewares/RedirectIfAuthenticatedMiddleware";

const Home = () => import("./components/Home.vue");
const Users = () => import("./components/Users.vue");
const Login = () => import("./components/Login.vue");
const Register = () => import("./components/Register.vue");

export const routes = [
    {
        name: "home",
        path: "/",
        component: Home
    },
    {
        name: "users",
        path: "/users",
        component: Users
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
    }
];
