<template>
  <div class="cadastro-container">
    <div class="left-sectionLogin">
    </div>

    <div class="right-section">
      <!-- Formulário de Cadastro -->
      <div>
        <div class="container_titulo">
          <h1 class="titulo">Login</h1>
          <p>Preencha as informações abaixo para entrar como guia ou turista</p>
        </div>
        <form class="login-form" @submit.prevent="handleSubmit">
          <input type="email" v-model="form.email" class="input-padrao" placeholder="Digite seu Email"
            pattern="[a-zA-Z0-9._%+-]+@\.com" required />

          <div class="container_lado-a-lado">
            <input :type="showPassword ? 'text' : 'password'" class="input-padrao" v-model="form.senha"
              placeholder="Digite sua senha" minlength="8" pattern="^(?=.*[0-9])(?=.*[\W_]).{8,}$" required />
            <!-- olho da senha -->

            <button class="olhos" type="button" @click="togglePassword">
              <img class="olhos" v-if="showPassword" src="../assets/imagem visualizar.jpg" alt="Mostrar senha">
              <img class="olhos" v-else src="../assets/imagem_não_visualizar.jpg" alt="Ocultar senha">
            </button>

          </div>
          <div>
            <button class="button-continuar" type="submit">Continuar</button>
            <router-link to="/cadastroUsuario" class="link-cadastro">Não tem uma conta? Cadastre-se agora!</router-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import useAuth from '../auth/auth.ts'

// Definir os dados do formulário
const form = ref({
  email: '',
  senha: ''
})
// configuração do olho do input senha
const showPassword = ref(false);

const togglePassword = () => {
  console.log("Estado atual:", showPassword.value);
  showPassword.value = !showPassword.value;
};

async function axiosLogin() {
  try {
    await useAuth.login(form.value);
  } catch (error) {
    console.log(error)
  } finally {
    router.push('/')
  }
}
// Função para verificar e submeter o formulário
const handleSubmit = (e) => {
  e.preventDefault();
  axiosLogin()
}
</script>
