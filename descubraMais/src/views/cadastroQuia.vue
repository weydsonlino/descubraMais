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
        <input type="text" class="nome" v-model="formData.name" minlength="3" maxlength="100" placeholder="Nome"
          required />
        <input type="text" class="valor" v-mask="'$ ##,###.##'" v-model="formData.valor" placeholder="Valor Hora"
          required />

        <h1>Selecione suas regiões da atuação</h1>

        <select class="pais" v-model="formData.pais" required>
          <option class="país" value="brasil">brasil</option>
          <option value="brasil">portugal</option>
          <option value="portugal">argentina</option>
          <option value="O">Outros</option>
        </select>

        <select class="region" v-model="formData.region" required>
          <option class="país" value="pernambuco">Pernambuco</option>
          <option value="brasil">São paulo</option>
          <option value="portugal">Amazonia</option>
          <option value="O">Outros</option>
        </select>

        <select class="estado" v-model="formData.estado" required>
          <option class="país" value="pernambuco">Pernambuco</option>
          <option value="brasil">São paulo</option>
          <option value="portugal">Amazonia</option>
          <option value="O">Outros</option>
        </select>


        <select class="cidade" v-model="formData.estado" required>
          <option class="país" value="pernambuco">Pernambuco</option>
          <option value="brasil">São paulo</option>
          <option value="portugal">Amazonia</option>
          <option value="O">Outros</option>
        </select>

      </form>
    </div>
  </div>
</template>

<script lang="ts">
import VueMask from 'vue-the-mask';

export default {
  data() {
    return {
      formData: {
        name: "",
        region: "",
        pais: "",
        estado: "",
        cidade: ""
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

.texto-imgem-Tutulo,
.texto-imgem-Centro,
.texto-imgem-Baixo {
  position: absolute;
  text-align: center;
  padding: 1rem;
  color: white;
}

.texto-imgem-Tutulo {
  top: 15%;
  left: 2%;
  width: 44%;
  font-family: Khmer;
  font-size: 20px;
}

.texto-imgem-Centro {
  top: 50%;
  left: 2%;
  width: 44%;
  font-family: Khmer;
  font-size: 16px;
}

.texto-imgem-Baixo {
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

.valor,
.nome,
.pais,
.region,
.cidade,
.estado,
button {
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
  left: 67%;
  /* Alinha o botão à esquerda */
  position: absolute;
  /* Define a posição absoluta em relação ao contêiner pai */
  border-radius: 25px;
  padding: 5px 50px;
  text-align: center;
  font-size: 20px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
}


button:hover {
  background-color: #e0a800;
}

.titulo {
  font-size: 25px;
  margin-bottom: 1rem;
  text-align: center;
}

.texto {
  margin-bottom: 1rem;
  text-align: center;
}

.linha {
  border: 1px solid #000;
  width: 100%;
}
</style>
Ravnos
