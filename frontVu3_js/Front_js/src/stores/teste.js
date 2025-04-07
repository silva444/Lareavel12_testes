import { defineStore } from "pinia";

export const useCount = defineStore('counter',{
    //state
   

    state(){
        return{
            coont : 0
        }
    },

    //actions // como se osse os metodos 
    actions:{
        increment(){
            this.coont++
        }
    },


    //getters // propiedades computadas
   getters:{
    

    showCount(){
        return "o valor do counter é " + this.coont;
    }

   }

})