<script setup lang="ts">
import CardMenorComponents from '@/components/CardMenorComponents.vue'
import { onMounted, ref } from 'vue'
import useAuth from '@/auth/auth.ts';
import { useRoute } from 'vue-router'
import {useRouter} from 'vue-router'

const route = useRoute()
const router = useRouter()
const pontosTuristicos = ref([])
const roteirosTuristicos = ref([])
const queryPesquisa = ref(route.query.nome as string);

async function axiosPontosRoteiros(){
  try{
    console.log(queryPesquisa.value)
    const response = await useAuth.axiosWithAuth(`/pesquisa?nome=${queryPesquisa.value}`)
    pontosTuristicos.value = response.pontosTuristicos
    roteirosTuristicos.value = response.roteirosTuristicos
    console.log(pontosTuristicos)
  }catch (error){
    console.log(error)
  }
}
const performSearch = () => {
  if (queryPesquisa.value.trim()) {
    router.push({ query: { nome: queryPesquisa.value } });
    axiosPontosRoteiros()
  }
};
onMounted(()=>{
  if(queryPesquisa.value){
  axiosPontosRoteiros()
  }
})

</script>
<template>
<main class="pesquisa-container">
  <header class="pesquisa-header">
    <input class="input" type="search" placeholder="pesquise" v-model="queryPesquisa"/>
    <button class="button-pesquisar" @click="performSearch">Pesquisar</button>
  </header>
  <article class="resultados-container">
    <section class="resultado">
      <div >
        <h2>Pontos Turisticos</h2>
        <div class="container-pontos-turistico">
          <CardMenorComponents v-for="ponto in pontosTuristicos" :title=ponto.nome :image=ponto.imagem alt="aa" :key = "ponto.id"/>
        </div>
      </div>
    </section>
    <section class="resultado">
      <div >
        <h2>Roteiros Turisticos</h2>
        <div class="container-pontos-turistico">
          <CardMenorComponents v-for="roteiro in roteirosTuristicos" :title=roteiro.nome image="src/assets/maragogi.png" alt="aa"/>
        </div>
      </div>
    </section>
  </article>
</main>
</template>
<style scoped>
.pesquisa-container{
  width: 100vw;
  height: 110vh;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.pesquisa-header{
  display: flex;
  justify-content: center;
  gap: 20px;
  margin: 40px;
  align-items: center;
}
.input{
  width: 922px;
  height: 36px;
  padding: 0px 7.606px;
  gap: -48px;
  flex-shrink: 0;
  border-radius: 14.262px;
  border: 0.951px solid #FFF;
  background: #FFF;
  box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, .25);
}
.button-pesquisar{
  width: 130px;
  height: 36px;
  flex-shrink: 0;
  border-radius: 35px;
  border: 1px solid rgba(0, 0, 0, 0.15);
  background: #F57C00;
  box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}
.resultados-container{
  display: flex;
  flex-direction: column;
  width: 1128px;
  height: fit-content;
  border-radius: 4px;
  background-color: #FFFFFF;
}
.resultado{
  display: flex;
  width: 1128px;
  height: 407px;
  padding: 2px 20px;
  flex-direction: column;
  align-items: flex-start;
  gap: 6px;
  flex-shrink: 0;
  margin-top: 35px;
}
.container-pontos-turistico {
  display: flex;
  padding: 10px;
  align-items: center;
  gap: 30px;
  flex-direction: row;
  overflow-x: auto; /* Mudando para auto */
  overflow-y: hidden; /* Garantindo que o eixo Y não tenha barra */
  max-width: 1080px; /* Evitando restrições */
  white-space: nowrap; /* Mantendo os elementos na mesma linha */
}

.container-pontos-turistico > * {
  flex-shrink: 0; /* Evita que os itens sejam reduzidos */
}

</style>
