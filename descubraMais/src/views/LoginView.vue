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
      <div v-if="formData.role === '' && isFormValid">
        <h1 class="titulo-form">Login</h1>
        <p class="texto-form">Preencha as informações abaixo para entrar como guia ou turista</p>

        <form class="cadastro-form" @submit.prevent="handleSubmit">
          <input type="email" v-model="email" class="input-padrao" placeholder="Digite seu Gmail"
            pattern="[a-zA-Z0-9._%+-]+@gmail\.com" required />

          <input :type="showPassword ? 'text' : 'password'" class="input-padrao" v-model="formData.senha"
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
      <Guia v-if="formData.role === 'GUIA' && isFormValid" :userData="formData" />
      <Turista v-else-if="formData.role === 'VIAJANTE' && isFormValid" :userData="formData" />
    </div>
  </div>
</template>

<script setup lang="ts">
import axios from 'axios'
import { ref } from 'vue'
import "../assets/css/cadastroUsuario.css"
import Guia from "../components/componentsUsuario/componentsGuia.vue"
import Turista from "../components/componentsUsuario/componentsTurista.vue"


const tipo = ref('');
// Definir os dados do formulário
const formData = ref({
  name: '',
  cpf: '',
  gender: '',
  phone: '',
  password: '',
  role: '', // Role será 'Guia' ou 'Turista'
})



const isFormValid = ref(true) // Começa como falso, para exibir o formulário inicialmente
const imagemSelecionada = ref(null);

// Para confirmar a senha
const confirmPassword = ref('')
// configuração do olho do input senha
const showPassword = ref(false);

const togglePassword = () => {
  console.log("Estado atual:", showPassword.value);
  showPassword.value = !showPassword.value;
};

//imagem do usuario
const imagem_user = (event) => {
  const arquivo = event.target.files[0]; // Pega o primeiro arquivo selecionado
  if (arquivo) {
    imagemSelecionada.value = URL.createObjectURL(arquivo);
  }
};
// Função para verificar e submeter o formulário
const handleSubmit = () => {
  if (tipo.value === 'GUIA') {
    formData.value.role = 'GUIA';
  } else if (tipo.value === 'VIAJANTE') {
    formData.value.role = 'VIAJANTE';
  } else {
    alert("pereencha todos os camplos")
  }
  // Verificar se as senhas são iguais antes de enviar o formulário
  if (formData.value.password !== confirmPassword.value) {
    alert("As senhas não coincidem.");
    return;
  }
}
</script>
