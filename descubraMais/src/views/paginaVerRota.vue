<template>
  <div class="cadastro-container">
    <div class="left-section1">
    </div>

    <div class="right-section"> <!-- Formulário de Cadastro -->

      <div class="container_titulo">

      </div>
      <form class="cadastro-form" @submit.prevent="handleSubmit">
        <div class="container_titulo">
          <h1 class="titulo">{{pontos[0].NOME}}</h1>
        </div>
        <img :src="pontos[0].IMAGEM" alt="Imagem" class="imagem-pequena" />
        <div class="descricao">Descrição: {{pontos[0].INFORMACOES}}</div>
        <div class="tipo">Tipo: {{pontos[0].TIPO}}</div>
        <div class="conteinerLaike">
          <button class="blue" @click="handleClick('blue')"></button>
          <button class="red" @click="handleClick('red')"></button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import "../assets/css/cadastroUsuario.css"
import useAuth from '@/auth/auth.ts'

const params = ref(1)
const pontos = ref([])
async function axiosPontos(){
  try {
  pontos.value = await useAuth.axiosWithAuth(`/pesquisa/1`)
  console.log(pontos.value)
  }catch (e){console.log(e)}
}

onMounted(()=>{
  axiosPontos()
})

</script>
