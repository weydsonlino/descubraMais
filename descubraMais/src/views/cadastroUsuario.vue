<template>
  <div class="container">
    <div class="left-section">
      <div class="texto-imgem-Tutulo">
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
        <h3 class="titulo">Cadastre-se</h3>
        <div class="imagem">
          <input type="file" @change="imagem_user" accept="image/*">
          <div v-if="imagemSelecionada">
            <img :src="imagemSelecionada" alt="Imagem do usuário" style="max-width: 300px;">
          </div>
        </div>
        <p class="texto">Seja um Guia ou apenas um viajante</p>

        <form class="formPrincipal" @submit.prevent="handleSubmit">
          <input type="text" class="nome" v-model="formData.name" minlength="3" maxlength="100" placeholder="Nome"
            required />

          <input type="text" class="cpf" v-mask="'###.###.###-##'" v-model="formData.cpf" placeholder="CPF" required />

          <select class="sexo" v-model="formData.gender" required>
            <option value="" disabled selected>Sexo</option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outros</option>
          </select>

          <input class="telefone" v-mask="'(##)#####-####'" type="tel" v-model="formData.phone" placeholder="Telefone"
            required />

          <div class="senha-container">
            <input type="password" class="senha" v-model="formData.password" placeholder="Senha" required />
            <input type="password" class="confirmar_senha" v-model="confirmPassword" placeholder="Confirmar Senha"
              required />
          </div>

          <select class="tipoUSU" v-model="tipo" required>
            <option value="" disabled selected>O que você é?</option>
            <option value="GUIA">Guia</option>
            <option value="VIAJANTE">Turista</option>
          </select>

          <button class="Button-Continuar" type="submit">Continuar</button>
          <p class="C">Já tem conta? Faça login</p>
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

// Para confirmar a senha
const confirmPassword = ref('')
const isFormValid = ref(true) // Começa como falso, para exibir o formulário inicialmente
const imagemSelecionada = ref(null);

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
