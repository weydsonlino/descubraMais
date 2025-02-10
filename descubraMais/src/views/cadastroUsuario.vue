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
          <input type="password" class="confirmar_senha" v-model="confirmPassword" placeholder="Confirmar Senha"
            required />
        </div>

        <select class="tipoUSU" v-model="formData.role" required>
          <option value="" disabled selected>O que você é?</option>
          <option value="Guia">Guia</option>
          <option value="Turista">Turista</option>
        </select>
        <button class="Button-Continuar" type="submit">Continuar</button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, computed } from "vue";
import { useRouter } from "vue-router";
import VueMask from "vue-the-mask";
import "@/assets/css/cadastroUsuario.css";
import { useUserStore } from "../stores/user"; // Corrigido o caminho da store

export default defineComponent({
  setup() {
    const userStore = useUserStore();
    const router = useRouter();
    const confirmPassword = ref('');

    // Criamos um objeto reativo para os dados do formulário
    const formData = ref({ ...userStore.userData });

    // Computed para recuperar os dados já preenchidos
    const userData = computed(() => userStore.userData);

    // Campos adicionais do Guia
    const valor = ref("");
    const pais = ref("");
    const estado = ref("");
    const cidade = ref("");

    // Função para salvar os dados do Guia no Pinia
    const salvarGuia = () => {
      userStore.setUserData({
        ...userStore.userData, // Mantém os dados anteriores
        valor: valor.value,
        pais: pais.value,
        estado: estado.value,
        cidade: cidade.value,
      });

      console.log("Dados completos do usuário:", userStore.userData);
    };

    // Função para salvar os dados do Turista no Pinia
    const salvarTurista = () => {
      userStore.setUserData({
        ...userStore.userData, // Mantém os dados anteriores
        valor: valor.value,
        pais: pais.value,
        estado: estado.value,
        cidade: cidade.value,
      });

      console.log("Dados completos do usuário:", userStore.userData);
    };

    // Função de envio do formulário inicial
    const handleSubmit = () => {
      if (formData.value.password !== confirmPassword.value) {
        alert("As senhas não coincidem. Por favor, verifique e tente novamente.");
        return;
      }

      // Salva os dados no Pinia
      userStore.setUserData(formData.value);

      // Redireciona com base na função do usuário
      if (formData.value.role === "Guia") {
        router.push("/cadastroGuia");
      } else if (formData.value.role === "Turista") {
        router.push("/cadastroTurista");
      }

      console.log("Form Data salvo no Pinia:", formData.value);
    };

    return {
      formData,
      handleSubmit,
      userData,
      valor,
      pais,
      estado,
      cidade,
      salvarGuia,
      salvarTurista,
      confirmPassword,
    };
  },
});
</script>
