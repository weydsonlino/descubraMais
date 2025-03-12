<script setup lang="ts">

const props = defineProps<{
    title: string,
    image: string,
    alt: string,
    }>()

</script>
<template>
 <div class="card">
     <img :src="props.image" :alt="props.alt">
     <div class="card-content">
         <h3>{{props.title}}</h3>
         <button>Explorar</button>
     </div>
 </div>
 </template>

<style scoped>
 .card {
     width: 250px;
     background: #fff;
     border-radius: 10px;
     box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
     overflow: hidden;
     text-align: center;
 }
 .card img {
     width: 100%;
     height: 150px;
     object-fit: cover;
 }
 .card-content {
     padding: 15px;
 }
 .card h3 {
     margin: 10px 0;
     font-size: 18px;
 }
 .card button {
     background: #002b5b;
     color: #fff;
     border: none;
     padding: 10px 15px;
     border-radius: 5px;
     cursor: pointer;
     font-size: 16px;
 }
 .card button:hover {
     background: #00509e;
 }
 </style>
