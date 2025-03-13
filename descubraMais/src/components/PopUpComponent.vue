<script setup lang="ts">
import { ref, watch } from "vue";
import {useRouter} from 'vue-router'

const route = useRouter()
const props = defineProps({
  message: String,
  type: String, // 'success' ou 'error'
  show: Boolean, // Controla a exibição
});

const visible = ref(props.show);

watch(() => props.show, (newVal) => {
  visible.value = newVal;
  if (newVal) {
    setTimeout(() => {
      visible.value = false;
      route.push('/')
    }, 2000); // Esconde após 3 segundos
  }
});
</script>

<template>
  <transition name="fade">
    <div v-if="visible" class="popup" :class="type === 'success' ? 'success' : 'error'">
      {{ message }}
    </div>
  </transition>
</template>

<style scoped>
/* Popup fixo abaixo do header */
.popup {
  position: fixed;
  top: 80px; /* Ajuste conforme a altura do seu header */
  left: 50%;
  transform: translateX(-50%);
  padding: 12px 20px;
  border-radius: 8px;
  color: white;
  font-size: 16px;
  font-weight: bold;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 1000; /* Garante que fique sobre o conteúdo */
}

/* Cores do popup */
.success {
  background-color: #28a745; /* Verde para sucesso */
}

.error {
  background-color: #dc3545; /* Vermelho para erro */
}

/* Animação de fade */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
