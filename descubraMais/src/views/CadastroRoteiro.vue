<script setup lang="ts">
import axios from "axios"
import { ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import RoteiroPrimeiraEtapa from '@/components/RoteiroPrimeiraEtapa.vue'
import RoteiroSegundaEtapa from '@/components/RoteiroSegundaEtapa.vue'

const router = useRouter()

const etapa = ref('primeiraEtapa')
const form = ref({
  cpf:'',
  nome:'',
  visibilidade: 'Publico',
  categoria: [],
  dificuldade:'',
  informacoes:'',
  pontosTuristicos: []
})

const handleSubmit = () => {
  form.value.cpf = "89512582031"
  axios.post('http://localhost:8000/roteirosturistico', form.value)
    .then(() => {
      router.push('/')
    })
    .catch((error) => {
      console.error('Erro ao cadastrar ponto turistico:', error);
    });
}

watch(() => etapa.value, () => {
  console.log(form.value)
});

</script>
<template>
  <div class="container">
    <div class="left-section">

    </div>
    <div class="right-section">
      <div class="form-header">
        <h3 class="titulo">Cadastre o seu Roteiro Turistico</h3>
        <p class="texto">Preencha as informações abaixo para adicionar um Roteiro turistico</p>
      </div>
      <form @submit.prevent="handleSubmit">
        <RoteiroPrimeiraEtapa v-if="etapa === 'primeiraEtapa'" v-model="form" @next="etapa ='segundaEtapa'"/>
        <RoteiroSegundaEtapa v-if="etapa === 'segundaEtapa'" v-model="form" @previus="etapa ='primeiraEtapa'"/>
        <button class="button-continuar" v-if="etapa === 'segundaEtapa'" type="submit">Cadastrar</button>
      </form>
    </div>
  </div>
</template>
<style scoped>

.container {
  margin: 4% 9%;
  display: flex;
  height: 105vh;
  font-family: 'Khmer', sans-serif;
  justify-content: flex-end;
}
.left-section {
  flex: 1;
  background-image: url('../assets/imagem_ponto_turisticos.png');
  background-size: cover;
  background-position: center;
  padding: 2rem;
}
.right-section {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  align-items: center;
  gap: 40px;
  padding: 3rem;
  background: #fff;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}
form {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.button-continuar {
  background-color: #F57C00;
  color:black;
  border: none;
  width: 250px;
  height: 40px;
  margin-top: 50px;
  border-radius: 25px;
  padding: 5px 50px;
  text-align: center;
  font-size: 20px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
}
button:hover {
  background-color: #e0a800;
}
.form-header{
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}
.titulo {
  color: #000;
  text-align: center;
  font-family: Roboto,serif;
  font-size: 32px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
}

.texto {
  color: rgba(0, 0, 0, 0.85);
  text-align: center;
  font-family: Roboto,serif;
  font-size: 13px;
  font-style: normal;
  font-weight: 300;
  line-height: normal;
}
select{
  display: flex;
  width: 140px;
  height: 41px;
  padding: 0 8px;
  margin-bottom: 20px;
  align-items: center;
  gap:-48px;
  border-radius: 14px;
  border: 1px solid #FFF;
  background: #FFF;
  box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.25);
  color: #828181;
  font-family: Roboto,serif;
  font-size: 14px;
  font-style: normal;
  font-weight: 200;
  line-height: 150%; /* 21px */
  letter-spacing: -0.154px;
}
option{
  color: #828181;
  font-family: Roboto,serif;
  font-size: 14px;
  font-style: normal;
  font-weight: 200;
  line-height: 150%; /* 21px */
  letter-spacing: -0.154px;
}
</style>
