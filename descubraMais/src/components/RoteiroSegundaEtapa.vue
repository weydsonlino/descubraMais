<script setup lang="ts">
import axios from "axios"
import { onMounted, ref } from 'vue'
import InputComponent from '@/components/InputComponent.vue'
import AdicionarFotos from '@/components/AdicionarFotos.vue'

defineProps(['modelValue'])

const pontosTuristico = ref<{ id: number; nome: string }[]>([]);
//const pesquisa = ref('')
async function axiosPontos(){
  try{
    const response = await axios.get('http://localhost:8000/pontosturisticos');
    pontosTuristico.value = response.data.data;
  }catch (error){
    console.error("Erro ao carregar os tipos:", error);
  }
}
onMounted(()=> {
  axiosPontos();
})

</script>

<template>
  <div class="container">
    <AdicionarFotos v-model="modelValue.imagens"/>
    <!--<InputComponent placeholder="Pesquise o ponto Turistico" type="search" v-model="modelValue.pesquisa"/>-->
    <h2>Selecione os pontos turisticos da sua rota</h2>
    <div class="container-checkbox" >
        <div v-for="ponto in pontosTuristico" :key="ponto.id" class="checkbox" >
          <label :for="ponto.id">
            {{ ponto.nome }}
          </label>
          <input type="checkbox" :name="ponto.id" :value="ponto.id" v-model="modelValue.pontosTuristicos" />
        </div>
      </div>
  </div>
</template>

<style scoped>
.container{
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 20px;
}
.container-checkbox{
  display: flex;
  width: 456px;
  height: 146px;
  padding: 0px 10px;
  flex-direction: column;
  align-items: center;
  flex-shrink: 0;
  overflow-x: hidden;
  overflow-y: auto;
  border-radius: 5px 5px 0px 0px;
  border: 1px solid #FFF;
  box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.25);
}
.checkbox{
  display: flex;
  justify-content: space-between;
  width: 456px;
  padding: 10px 30px;
  align-items: center;
  gap: 10px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.20);
  }
</style>
