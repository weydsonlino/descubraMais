<template>

  <div class="cadastro-container">
    <div class="left-section">
      <div class="form-header">
        <h3 class="titulo-form">Cadastre o seu Roteiro Turistico</h3>
        <p class="texto-form">Preencha as informações abaixo para adicionar um Roteiro turistico</p>
      </div>
    </div>

    <div class="right-section"> <!-- Formulário de Cadastro -->
      <div v-if="formData.role === '' && isFormValid">
        <h3 class="titulo">Cadastre-se</h3>
        <div class="imagem">
          <input type="file" @change="imagem_user" accept="image/*">
          <div v-if="imagemSelecionada">
            <img :src="imagemSelecionada" alt="Imagem do usuário" style="max-width: 300px;">
          </div>
        </div>
        <p class="texto">Seja um Guia ou apenas um viajante</p>

        <form class="cadastro-form" @submit.prevent="handleSubmit">
          <input type="text" class="input-padrao" v-model="formData.name" minlength="3" maxlength="100"
            placeholder="Nome" required />

          <input type="email" v-model="formData.gmail" class="input-padrao" placeholder="Digite seu Gmail"
            pattern="[a-zA-Z0-9._%+-]+@gmail\.com" required />


          <input type="text" class="input-padrao" v-mask="'###.###.###-##'" v-model="formData.cpf" placeholder="CPF"
            required />

          <select class="input-padrao" v-model="formData.gender" required>
            <option value="" disabled selected>Sexo</option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outros</option>
          </select>

          <input class="input-padrao" v-mask="'(##)#####-####'" type="tel" v-model="formData.phone"
            placeholder="Telefone" required />

          <div class="container_lado-a-lado">
            <input type="password" class="input_lado-a-lado" v-model="formData.password" placeholder="Senha" required />
            <input type="password" class="input_lado-a-lado" v-model="confirmPassword" placeholder="Confirmar Senha"
              required />
          </div>

          <select class="input-padrao" v-model="tipo" required>
            <option value="" disabled selected>O que você é?</option>
            <option value="GUIA">Guia</option>
            <option value="VIAJANTE">Turista</option>
          </select>

          <button class="button-continuar" type="submit">Continuar</button>
          <p class="Conta">Já tem conta? Faça login</p>
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
  gmail: '',
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
