<script setup lang="ts">
import { ref } from "vue";

const email = ref("");
const password = ref("");
const name = ref("");

function mostrar() {
  console.log(email);
  console.log(password);
  console.log(name);
}
</script>

<template>
  <main>
    <div class="container">
      <form class="form_register" @submit="mostrar()">
        <label for="email">Email</label>
        <input type="text" v-model="email" class="form_input" placeholder="Digite o Email" />
        <label for="email">Senha</label>
        <input type="text" v-model="password" class="form_input" placeholder="Digite a senha" />
        <button class="form_button">Login</button>
      </form>
    </div>
  </main>
</template>

<style scoped>
main {
  height: 100vh;
  /* background-color: red; */
}

.container {
  height: 100%;
  background: linear-gradient(to bottom, rgb(30, 144, 255), rgb(0, 255, 127));
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  justify-content: center;
}
.form_register {
  width: 40%;
  /* background-color: red; */
  display: flex;
  flex-flow: column nowrap;
  gap: 10px;
  align-items: center;
}
label {
}
.form_button {
  width: 40%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.form_button:hover {
  background-color: rgb(108, 108, 108);
}
.form_input {
  border: 1px solid #ccc;
  width: 100%;
  box-sizing: border-box;
  border-radius: 5px;
  height: 40px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
