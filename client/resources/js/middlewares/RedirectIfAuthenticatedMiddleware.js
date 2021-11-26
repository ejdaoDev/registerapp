export default function RedirectIfAuthenticated(to, from, next){
    if(localStorage.getItem('auth.token') != null){
        next({name:'home'});
    }
    next();
}