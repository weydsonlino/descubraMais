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
.container-select{
  display: flex;
}
</style>
