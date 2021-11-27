export default function Auth(to, from, next){
    if(localStorage.getItem('auth.token') == null){
        next({name:'home'});
    }
    next();
}