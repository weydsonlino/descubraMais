<template>

  <div class="cadastro-container">
    <div class="left-section1">
    </div>

    <div class="right-section"> <!-- Formulário de Cadastro -->

      <div class="container_titulo">

      </div>
      <form class="cadastro-form" @submit.prevent="handleSubmit">
        <div class="container_titulo">
          <h1 class="titulo">ver rotas</h1>
        </div>
        <img :src="imagemUrl" alt="Imagem" class="imagem-pequena" />


        <div class="nome">Nome: aaaaaaaaaaaaaaaaaaaaaaa</div>
        <div class="descricao">Descrição: qqqqqqqqqqqqqqqqqqqq</div>
        <div class="dificuldade">Dificuldade: qqqqqqqqqqqqqqq</div>
        <div class="tipo">Tipo: qqqqqqqqqqqqqqqqqq</div>
        <div class="conteinerLaike">
          <button class="blue" @click="handleClick('blue')"></button>
          <button class="red" @click="handleClick('red')"></button>
        </div>
        <div class="dropdown-menu">
          <div v-for="cidade in jsonDadosCidades" :key="cidade.id" class="option-item">
            <label class="option-label">
              {{ cidade.nome }}
              <input type="checkbox" :id="'cidade-' + cidade.id" :value="cidade" v-model="estados_selecionados" />
              <span class="checkmark-box"></span>
            </label>
          </div>
        </div>
      </form>
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
