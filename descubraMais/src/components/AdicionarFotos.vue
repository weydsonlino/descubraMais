<script setup lang="ts">
import {  ref } from 'vue'
const props = defineProps(['modelValue'])

const images = ref<File[]>([]);

const handleFileUpload = (event) => {
  const files = event.target.files;

  for (const file of files) {
    const reader = new FileReader();

    reader.onload = (e) => {
      images.value.push(e.target.result); // Adiciona a imagem ao array
      props.modelValue.append("imagens[]", file);
    };

    reader.readAsDataURL(file);
  }
};
</script>

<template>
  <div class="container-add-imagem">
    <label for="upload" class="upload-label">
      <img src="../assets/addImage.png" alt="Adicionar imagem" class="add-imagem"  />
    </label>
    <input type="file" id="upload" accept="image/*" multiple hidden @change="handleFileUpload">
      <img v-for="(img, index) in images" :key="index" :src="img" alt="Imagem adicionada" class="add-imagem" />
  </div>
</template>

<style scoped>
.container-add-imagem{
  display: flex;
  width: 446px;
  height: 150.6px;
  padding: 13px 12px;
  align-items: flex-start;
  gap: 10px;
  flex-shrink: 0;
  border: 1px solid #FFF;
  box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.25);
  overflow-x: auto;
  overflow-y: hidden;
  scroll-snap-type: x mandatory;
  scrollbar-width: none; /* Esconde a barra no Firefox */
  -ms-overflow-style: none; /* Esconde a barra no IE/Edge */
}
.container-add-imagem::-webkit-scrollbar {
  display: none; /* Esconde a barra no Chrome/Safari */
}
.add-imagem{
  width: 124.6px;
  height: 124.6px;
  flex-shrink: 0;
  aspect-ratio: 124.60/124.60;
  scroll-snap-align: center;
}
.upload-label {
  cursor: pointer;
}

</style>
