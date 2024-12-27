<script lang="ts" setup>
import { RouterLink } from 'vue-router'
</script>
<template>
  <header id="header">
    <RouterLink to="/"><img src="../assets/DescubraMaisLogo.png" alt="" srcset="" /></RouterLink>
    <nav id="header-Navigation">
      <RouterLink to="/adicionarPontoTuristico" class="header-link">Pontos Turistico</RouterLink>
      <RouterLink to="/about" class="header-link">Sobre nós</RouterLink>
      <RouterLink to="/login" class="button header-link">Entrar</RouterLink>
      <RouterLink to="/cadastroUsuario" class="button register-button header-link">Cadastrar</RouterLink>
    </nav>
  </header>
</template>
