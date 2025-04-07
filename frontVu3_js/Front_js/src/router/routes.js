// retirei do inde para colocar aqui; tipo uma biblioteca
import { useAuthStore } from "@/stores/auth.js";
// pege os valores da auth.js , controle de estado com pinia;






// antes de cada rota , vai executar oque está aqui;
// e to é rota que eu estou indo;
// from -> rota que eu estou vindo ,
// next -> deixa proseguir a rota,  e posso usar para redirecionar Tambem;

export default async function routesLink(to,from,next){
// a ? é para veriicar se exiiste o auth dentro do meta;
// to.meta.auth sem do index.js da pasta router;
if (to.meta?.auth) {
    const auth = useAuthStore();

    if (auth.token && auth.user) {
      // verifica se o token é valido;
      const isAutenticate = await auth.checkToken();

      if (isAutenticate) {
        console.log(isAutenticate);
        next();
      }else {
        next({name:'login'});
      }
    }else {
      // se não exisir nem toke nem user redirecionar para tela de login; 
      next({name:'login'});
    }
    console.log(to.name);
  }else {
    // se não tem nehum auth;
    next();
  }
}