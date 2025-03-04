<template>
  <div class="cadastro-container">
    <div class="left-section">

      <div class="form-header">
        <h2>Crie sua Conta e Explore o Mundo com<br> Descubra Mais!</h2>
      </div>
      <div class="texto-imgem-Centro">
        <p>Bem-vindo(a) ao Descubra Mais, sua plataforma para planejar viagens inesquecíveis.</p>
      </div>
      <div class="texto-imgem-Baixo">
        <p>Cadastre-se agora e comece a explorar o mundo do seu jeito!</p>
      </div>
    </div>

    <div class="right-section">
      <!-- Formulário de Cadastro -->
      <div>
        <h1 class="titulo-form">Login</h1>
        <p class="texto-form">Preencha as informações abaixo para entrar como guia ou turista</p>

        <form class="login-form" @submit.prevent="handleSubmit">
          <input type="email" v-model="form.email" class="input-padrao" placeholder="Digite seu Email"
            pattern="[a-zA-Z0-9._%+-]+@\.com" required />

          <input :type="showPassword ? 'text' : 'password'" class="input-padrao" v-model="form.senha"
            placeholder="Digite sua senha" minlength="8" pattern="^(?=.*[0-9])(?=.*[\W_]).{8,}$" required />
          <!-- olho da senha -->
          <button type="button" @click="togglePassword">
            <span v-if="showPassword">👁️</span>
            <span v-else>👁️‍🗨️</span>
          </button>

          <button class="button-continuar" type="submit">Continuar</button>
          <p class="C">Não tem uma conta? Cadastre-se agora!</p>
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

async function axiosLogin(){
  try {
    await useAuth.login(form.value);
  }catch (error){
    console.log(error)
  }finally {
    router.push('/')
  }
}
// Função para verificar e submeter o formulário
const handleSubmit = (e) => {
  e.preventDefault();
  axiosLogin()
}
</script>
