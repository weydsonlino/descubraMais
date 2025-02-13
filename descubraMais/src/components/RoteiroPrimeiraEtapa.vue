<script setup lang="ts">
import InputComponent from '@/components/InputComponent.vue'
import { defineProps, defineEmits, onMounted, ref } from 'vue'
import axios from 'axios'

const props = defineProps(['modelValue'])
const emit = defineEmits(['next', 'update:modelValue'])

const tipos = ref<{ id: number; nome: string }[]>([]);

async function axiosTipos(){
  try{
    const response = await axios.get('http://localhost:8000/tipospontoturistico');
    tipos.value = response.data.data;
  }catch (error){
    console.error("Erro ao carregar os tipos:", error);
  }
}

const addCategoria = (event: Event) => {
  const selectedId = (event.target as HTMLSelectElement).value

  const selectedTipo = tipos.value.find(tipo => tipo.id.toString() === selectedId)
  if (selectedTipo && !props.modelValue.categoria.some(cat => cat.id === selectedTipo.id)) {
    emit('update:modelValue', {
      ...props.modelValue,
      categoria: [...props.modelValue.categoria, selectedTipo] // Agora armazenamos { id, nome }
    })
  }

  (event.target as HTMLSelectElement).value = ""
}

onMounted(() => {
  axiosTipos();
})

</script>

<template>
  <InputComponent name="nome" placeholder="Nome da Rota" type="text" v-model="modelValue.nome"/>
  <InputComponent name="informacoes" placeholder="Descrava o Ponto Turistico" type="text" v-model="modelValue.informacoes"/>
    <select class="select-maior" @change="addCategoria">
      <option value="" disabled selected>Selecione a Categoria</option>
      <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">{{ tipo.nome }}</option>
    </select>
  <ul>
    <li v-for="(categoria, index) in modelValue.categoria" :key="index">
      {{ categoria.nome }}
    </li>
  </ul>
    <select class="select-maior" v-model="modelValue.dificuldade">
      <option value="" disabled selected>Selecione a Difuldade</option>
      <option value="Facil">Facil</option>
      <option value="Medio">Médio</option>
      <option value="Dificil">Dificil</option>
    </select>
  <button class="button-continuar" @click="$emit('next')">Próxima Etapa</button>
</template>

<style scoped>

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
.container-select{
  display: flex;
}
</style>
