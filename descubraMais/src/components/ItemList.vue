<template>
  <div>
    <h2>Lista de Itens</h2>
    <div v-for="(item, index) in store.itens" :key="index" class="item">
      {{ item }}
    </div>
  </div>
</template>

<script setup>
import { useItemStore } from '@/stores/store';

const store = useItemStore();
</script>

<style scoped>
.item {
  background: #f3f3f3;
  padding: 10px;
  margin: 5px 0;
  border-radius: 5px;
}
</style>
