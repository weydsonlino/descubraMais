<template>
  <div class="container">
    <div class="left-section">
      <div class="texto-imgem-Tutulo">
        <h2>Crie sua Conta e Explore o Mundo com<br> Descubra Mais!</h2>
      </div>
      <div class="texto-imgem-Centro">
        <p>Bem-vindo(a) ao Descubra Mais, sua plataforma para planejar viagens inesquecíveis.</p>
      </div>
      <div class="texto-imgem-Baixo">
        <p>Cadastre-se agora e comece a explorar o mundo do seu jeito!</p>
      </div>
    </div>
    <div class="right-section">
      <h3 class="titulo">Cadastre-se</h3>
      <p class="texto">Seja um Guia ou apenas um viajante</p>

      <form class="formPrincipal" @submit.prevent="handleSubmit">
        <input type="text" class="nome" v-model="formData.name" minlength="3" maxlength="100" placeholder="Nome"
          required />
        <input type="text" class="cpf" v-mask="'###.###.###-##'" v-model="formData.cpf" placeholder="CPF" minlength="14"
          required />

        <select class="sexo" v-model="formData.gender" placeholder="sexo" required>
          <option value="" disabled selected>Sexo</option>
          <option value="M">Masculino</option>
          <option value="F">Feminino</option>
          <option value="O">Outros</option>
        </select>

        <input class="telefone" v-mask="'(##)#####-####'" type="tel" v-model="formData.phone" minlength="15"
          placeholder="Telefone" required />
        <div class="senha-container">
          <input type="password" class="senha" v-model="formData.password" placeholder="Senha" required />
          <input type="password" class="confirmar_senha" v-model="formData.confirmPassword"
            placeholder="Confirmar Senha" required />
        </div>

        <select class="tipoUSU" v-model="formData.role" required>
          <option value="" disabled selected>O que você é?</option>
          <option value="GUIA">Guia</option>
          <option value="VIAJANTE">Viajante</option>
        </select>
        <button class="Button-Continuar" type="submit">Continuar</button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { defineStore, createPinia } from 'pinia';
import { createApp } from 'vue';
import { useRouter } from 'vue-router'; // Importando useRouter
import VueMask from 'vue-the-mask';
import '@/assets/css/cadastroUsuario.css';

// Definição da Store
const useUserStore = defineStore('user', {
  state: () => ({
    userData: {
      name: "",
      cpf: "",
      gender: "",
      phone: "",
      password: "",
      confirmPassword: "",
      role: "",
    },
  }),
  actions: {
    setUserData(data: any) {
      this.userData = data;
    },
  },
});

export default defineComponent({
  setup() {
    const userStore = useUserStore();
    const formData = { ...userStore.userData };
    const router = useRouter(); // Usando useRouter para acessar o router

    const handleSubmit = () => {
      if (formData.password !== formData.confirmPassword) {
        alert("As senhas não coincidem!");
        return;
      }
      // Realizar a lógica de envio aqui
      userStore.setUserData(formData);

      if (formData.role === "Guia") {
        router.push('cadastroGuia'); // Usando router.push em vez de $router.push
      } else if (formData.role === "Turista") {
        router.push('cadastroTurista'); // Usando router.push
      }
      console.log("Form Data:", formData);
    };

    return {
      formData,
      handleSubmit,
    };
  },
});

// Configuração do Pinia
const pinia = createPinia();
const app = createApp({});
app.use(pinia);
</script>
