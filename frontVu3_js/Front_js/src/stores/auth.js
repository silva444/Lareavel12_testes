import { ref } from "vue";
import { defineStore } from "pinia";
import http from '@/services/http.js'

export const useAuthStore = defineStore("auth", () => {
  const token = ref(localStorage.getItem("token"));
  //  uso o JSON para convert a string em Json;
  const user = ref(localStorage.getItem("user"));

  function setToken(tokenValue) {
    localStorage.setItem("token", tokenValue);
    token.value = tokenValue; // o token criado como const , vai receber o valor passado por paramentro;
  }
  function setUser(userValue) {
    localStorage.setItem("user", JSON.stringify(userValue));
    user.value = userValue; // o token criado como const , vai receber o valor passado por paramentro;
  }
  function clear(){
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    token.value=''
    user.value=''
  }
  function isAutenticated(){
      return token.value && token.value;
  }
  async function checkToken(){
    try {
      const tokenAtuh = 'Bearer' + token.value;
      const {data} = await http.get('v1/checkTK',{
         headers:{
            Authorization: tokenAtuh,
         }
      }); 
      return data;
    } catch (error) {
       console.log(error.response.data)
    }
  }

  return {
    token,
    user,
    setToken,
    setUser,
    checkToken,
    clear,
    isAutenticated
  };
});
