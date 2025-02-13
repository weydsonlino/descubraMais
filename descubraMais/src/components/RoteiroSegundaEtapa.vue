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
.select-maior{
  width: 456px;
  height: 41px;
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
