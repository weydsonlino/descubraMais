<script lang="ts" setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router';

const token = ref('')
token.value = localStorage.getItem('token');
const showDropdown = ref(false);

</script>

<template>
  <header id="header">
    <RouterLink to="/">
      <img src="../assets/DescubraMaisLogo.png" alt="Logo" />
    </RouterLink>

    <nav id="header-Navigation" v-if="!token">
      <RouterLink to="/" class="header-link">Pontos Turístico</RouterLink>
      <RouterLink to="/about" class="header-link">Sobre nós</RouterLink>
      <RouterLink to="/login" class="button header-link">Entrar</RouterLink>
      <RouterLink to="/cadastroUsuario" class="button register-button header-link">Cadastrar</RouterLink>
    </nav>

    <nav id="header-Navigation" v-else>
      <RouterLink to="/" class="header-link">Pontos Turístico</RouterLink>
      <RouterLink to="/about" class="header-link">Sobre nós</RouterLink>

      <div class="menu-container" @click="showDropdown = !showDropdown">
        <img src="../assets/icons8-cardápio-50 (1).png" alt="Ícone do menu" class="menu-icon">
        <ul v-if="showDropdown" class="dropdown-menu">
          <li><RouterLink class="links-dropdown" to="/cadastropontoturistico">Cadastrar Ponto Turistico</RouterLink></li>
          <li><RouterLink class="links-dropdown" to="/cadastroroteiro">Cadastrar Roteiro Turistico</RouterLink></li>
          <li><RouterLink class="links-dropdown" to="/">Sair</RouterLink></li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<style scoped>

</style>
