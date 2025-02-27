<script setup lang="ts">
import axios from "axios"
import { onMounted, ref, defineProps, defineEmits } from 'vue'

const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue'], ['previus'])

const pontosTuristico = ref<{ id: number; nome: string }[]>([]);

async function axiosPontos(){
  try{
    const response = await axios.get('http://localhost:8000/pontoturistico');
    pontosTuristico.value = response.data.data;
  }catch (error){
    console.error("Erro ao carregar os tipos:", error);
  }
}

const addPonto = (event: Event) => {
  const selectedId = (event.target as HTMLSelectElement).value

  const selectedPonto = pontosTuristico.value.find(ponto => ponto.id.toString() === selectedId)
  if (selectedPonto && !props.modelValue.pontosTuristicos.some(ponto => ponto.id === selectedPonto.id)) {
    emit('update:modelValue', {
      ...props.modelValue,
      pontoTuristico: [...props.modelValue.pontosTuristicos, selectedPonto] // Agora armazenamos { id, nome }
    })
  }
}

onMounted(()=> {
  axiosPontos();
})

</script>

<template>
  <select class="select-maior" @change="addPonto">
    <option value="">Escolha os Pontos Turistico da sua rota</option>
    <option v-for="ponto in pontosTuristico" :key="ponto.id" :value="ponto.id">{{ponto.nome}} </option>
  </select>
  <ul>
    <li v-for="(ponto, index) in modelValue.pontoTuristico" :key="index">
      {{ ponto.nome }}
    </li>
  </ul>
</template>

<style scoped>

</style>
