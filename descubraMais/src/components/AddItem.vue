<template>
  <div>
    <input v-model="novoItem" placeholder="Digite um valor" />
    <button @click="adicionar">Adicionar</button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useUserStore } from '@/stores/user';

const store = useUserStore();
const novoItem = ref('');

const adicionar = () => {
  if (novoItem.value.trim() !== '') {
    store.setQuiaData({ valor: novoItem.value });
    novoItem.value = ''; // Limpa o campo após adicionar
  }
};
</script>
