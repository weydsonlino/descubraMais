<script setup lang="ts">
const props = defineProps<{ 
  imagem: string;
  titulo: string;
  descricao: string;
}>();
</script>

<template>
  <div class="carrossel">
   <div class="card">
    <img :src="props.imagem" alt="Imagem do card" class="card-image" />
    <div class="card-content">
     <h2 class="card-title">{{ props.titulo }}</h2>
     <p class="card-text">{{ props.descricao }}</p>
     <button class="visit-button">Visitar</button>
    </div>
   </div>
  </div>
</template>

<style scoped>

.carrossel {
    margin-top: 10%;
    display: flex;
    gap: 20px;
    width: 100%;
    position: relative;
  }
  
  .card {
    width: 350px;
    height: 450px;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    animation: scroll 10s linear infinite;
  }
  
  .card-image {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 15px 15px 0 0;
  }
  
  .card-content {
    flex-grow: 1;
    padding: 10px;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  
  .card-title {
    color: #003049;
    text-align: center;
    font-family: Roboto;
    font-size: 20px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    letter-spacing: -1.3px;
  }
  
  .card-text {
    color: #1e1e1e;
    text-align: justify;
    font-family: "Roboto Serif";
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    letter-spacing: 0.192px;
    padding: 18px;
  }
  
  .visit-button {
    border: none;
    align-self: center;
    color: white;
    display: flex;
    width: 210px;
    height: 49px;
    padding: 8px 16px;
    justify-content: center;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
    border-radius: 25px;
    background: #014467;
  }
  
  .visit-button:hover {
    background-color: #0056b3;
  }
  
  @keyframes scroll {
    from {
      transform: translateX(100%);
    }
    to {
      transform: translateX(-100%);
    }
  }
</style>