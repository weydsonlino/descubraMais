<script setup lang="ts">
import InputComponent from '@/components/InputComponent.vue'
import { onMounted, ref } from 'vue'
import axios from 'axios'

defineProps(['modelValue'])
defineEmits(['next', 'update:modelValue'])

const tipos = ref<{ id: number; nome: string }[]>([]);

async function axiosTipos(){
  try{
    const response = await axios.get('http://localhost:8000/tipospontosturisticos');
    tipos.value = response.data.data;
  }catch (error){
    console.error("Erro ao carregar os tipos:", error);
  }
}
onMounted(() => {
  axiosTipos();
})

</script>

<template>
  <InputComponent name="nome" placeholder="Nome da Rota" type="text" v-model="modelValue.nome"/>
  <InputComponent name="informacoes" placeholder="Descrava o Ponto Turistico" type="text" v-model="modelValue.informacoes"/>
    <select class="select-maior" v-model="modelValue.dificuldade">
      <option value="" disabled selected>Selecione a Difuldade</option>
      <option value="Facil">Facil</option>
      <option value="Medio">Médio</option>
      <option value="Dificil">Dificil</option>
    </select>
    <select class="select-maior" v-model="modelValue.visibilidade">
      <option value="" disabled selected>Selecione a Difuldade</option>
      <option value="publico">Publico</option>
      <option value="privado">Privado</option>
    </select>

    <div class="container-checkbox" >
      <div v-for="tipo in tipos" :key="tipo.id" class="checkbox" >
        <label :for="tipo.id">
          {{ tipo.nome }}
        </label>
        <input type="checkbox" :name="tipo.id" :value="tipo.id" v-model="modelValue.categorias" />
      </div>
    </div>
  <button class="button-continuar" @click="$emit('next')">Próxima Etapa</button>
</template>

<style scoped>
.container-select{
  display: flex;
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
