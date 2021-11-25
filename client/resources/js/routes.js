const Home = () => import("./components/Home.vue");
const Users = () => import("./components/Users.vue");

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
    }
];
