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

      <form @submit.prevent="handleSubmit">
        <input type="text" class="nome" v-model="formData.name" placeholder="Nome" required />
        <input type="text" class="cpf" v-model="formData.cpf" placeholder="CPF" required />

        <select class="sexo" v-model="formData.gender" required>
          <option class="sexo" value="">Sexo</option>
          <option value="M">Masculino</option>
          <option value="F">Feminino</option>
          <option value="O">Outros</option>
        </select>

        <input class="telefone" type="tel" v-model="formData.phone" placeholder="Telefone" required />
        <input class="senha" type="password" v-model="formData.password" placeholder="Senha" required />
        <input class="senha" type="password" v-model="formData.confirmPassword" placeholder="Confirma senha" required />

        <div class="radio-group">
            <label>
                 Guia
                 <input class="radia-quaia" type="radio" value="guia" v-model="formData.role" required />
            </label>
            <hr class="linha">
            <label>
                 Turista
                 <input class="radia-turista" type="radio" value="turista" v-model="formData.role" required />
            </label>
            <hr class="linha">

        </div>
        <button class="Button-Continuar" type="submit">Continuar</button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
export default {
  data() {
    return {
      formData: {
        name: "",
        cpf: "",
        gender: "",
        phone: "",
        password: "",
        confirmPassword: "",
        role: "",
      },
    };
  },
  methods: {
    handleSubmit() {
      if (this.formData.password !== this.formData.confirmPassword) {
        alert("As senhas não coincidem!");
        return;
      }
      // Realizar a lógica de envio aqui
      console.log("Form Data:", this.formData);
    },
  },
};
</script>

<style scoped>
.container {
  display: flex;
  height: 105vh;
  font-family: 'Khmer', sans-serif;
  justify-content: flex-end;
}

.left-section {
  flex: 1;
  background-image: url('../assets/mountain-landscape-with-hot-air-balloon-dawn-generative-ai.jpg');
  background-size: cover;
  background-position: center;
  padding: 2rem;
}

.texto-imgem-Tutulo,.texto-imgem-Centro,.texto-imgem-Baixo {
  position: absolute;
  text-align: center;
  padding: 1rem;
  color: white;
}
.texto-imgem-Tutulo{
  top: 15%;
  left: 2%;
  width: 44%;
  font-family: Khmer;
  font-size: 20px;
}

.texto-imgem-Centro{
  top: 50%;
  left: 2%;
  width: 44%;
  font-family: Khmer;
  font-size: 16px;
}

.texto-imgem-Baixo{
  top: 100%;
  left: 2%;
  width: 44%;
  font-family: Kite One;
  font-size: 16px;
}

.radio-group {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 0.5rem;
}

.radio-group label {
  display: flex;
  align-items: center;
}

.radio-group input {
  margin-left: 0.5rem;
}


.right-section {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 3rem;
  background: #fff;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

form {
  display: flex;
  flex-direction: column;
}

.cpf,.nome,.telefone,.senha,.sexo, button {
  margin: 0.8rem 0;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  background-color: #F5F5F5;
  font-size: 1rem;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.3);
}

.Button-Continuar {
  background-color: #f2d050;
  color: #fff;
  border: none;
  width: 250px;
  height: 40px;
  top: 107%;
  left: 67%; /* Alinha o botão à esquerda */
  position: absolute; /* Define a posição absoluta em relação ao contêiner pai */
  border-radius: 25px;
  padding: 5px 50px;
  text-align: center;
  font-size: 20px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
}


button:hover {
  background-color: #e0a800;
}
.titulo{
  font-size: 25px;
  margin-bottom: 1rem;
  text-align: center;
}
.texto{
  margin-bottom: 1rem;
  text-align: center;
}
.linha{
  border: 1px solid #000;
   width: 100%;
}
</style>
