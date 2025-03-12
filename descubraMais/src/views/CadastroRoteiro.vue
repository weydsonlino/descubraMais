<script setup lang="ts">
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import RoteiroPrimeiraEtapa from '@/components/RoteiroPrimeiraEtapa.vue'
import RoteiroSegundaEtapa from '@/components/RoteiroSegundaEtapa.vue'
import useAuth from '@/auth/auth.ts'

const router = useRouter()

const etapa = ref('primeiraEtapa')
const form = ref({
  pesquisa:'',
  nome:'',
  visibilidade: '',
  categorias: [],
  dificuldade:'',
  informacoes:'',
  pontosTuristicos: [],
  imagens: []
})

async function axiosRoteiro(){
  /*const payload = JSON.parse(JSON.stringify(form.value)); // Remove qualquer reatividade do Vue
  console.log(payload)*/
  try {
    const response = await useAuth.axiosWithAuth('/roteirosturisticos', {
      method: 'POST',
      data: form.value
    })
    console.log(response)
  }catch (error){
    console.log(error)
  }
}

const handleSubmit = () => {
  console.log(form)
  axiosRoteiro()
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
      <div class="form-header" v-if="etapa == 'primeiraEtapa'">
        <h3 class="titulo-form">Cadastre o seu Roteiro Turistico</h3>
        <p class="texto-form">Preencha as informações abaixo para adicionar um Roteiro turistico</p>
      </div>
      <div class="form-header" v-if="etapa == 'segundaEtapa'">
        <h3 class="titulo-form">Adcione fotos e Pontos Turisticos</h3>
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
