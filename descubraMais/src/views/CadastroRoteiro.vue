<script setup lang="ts">
import axios from "axios"
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import RoteiroPrimeiraEtapa from '@/components/RoteiroPrimeiraEtapa.vue'
import RoteiroSegundaEtapa from '@/components/RoteiroSegundaEtapa.vue'

const router = useRouter()

const etapa = ref('primeiraEtapa')
const form = ref({
  pesquisa:'',
  nome:'',
  visibilidade: '',
  categorias: [],
  dificuldade:'',
  informacoes:'',
  pontosTuristicos: []
})

const handleSubmit = () => {
  axios.post('http://localhost:8000/roteirosturistico', form.value)
    .then(() => {
      router.push('/')
    })
    .catch((error) => {
      console.error('Erro ao cadastrar ponto turistico:', error);
    });
}

watch(() => form.value, () => {
  console.log(form.value)
});

</script>
<template>
  <div class="cadastro-container">
    <div class="left-section">

    </div>
    <div class="right-section">
      <div class="form-header">
        <h3 class="titulo-form">Cadastre o seu Roteiro Turistico</h3>
        <p class="texto-form">Preencha as informações abaixo para adicionar um Roteiro turistico</p>
      </div>
      <form @submit.prevent="handleSubmit" class="cadastro-form">
        <RoteiroPrimeiraEtapa v-if="etapa === 'primeiraEtapa'" v-model="form" @next="etapa ='segundaEtapa'"/>
        <RoteiroSegundaEtapa v-if="etapa === 'segundaEtapa'" v-model="form" />
        <button class="button-continuar" v-if="etapa === 'segundaEtapa'" type="submit">Cadastrar</button>
      </form>
    </div>
  </div>
</template>
<style scoped>

</style>
