<template>
  <div class="container">
    <div class="left-section">
      <div class="texto-imgem-Tutulo">
        <h2>Crie sua Conta e Explore o Mundo com<br />Descubra Mais!</h2>
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

        <h4>Selecione suas regiões de atuação</h4>

        <select class="pais" v-model="formData.pais" required>
          <option selected disabled>pais</option>
          <option v-for="pais in SelectPais" :key="pais.id" :value="pais.id">
            {{ pais.nome }}
          </option>
        </select>

        <select class="estado" v-model="formData.estado" required>
          <option v-for="estado in filteredEstados" :key="estado.id" :value="estado.id">
            {{ estado.nome }}
          </option>
        </select>

        <select class="cidade" v-model="formData.cidade" required>
          <option v-for="cidade in filteredCidades" :key="cidade.id" :value="cidade.id">
            {{ cidade.cidade }}
          </option>
        </select>

        <button type="submit">Cadastrar</button>
      </form>
    </div>
  </div>
</template>


<script lang="ts">
import VueMask from "vue-the-mask";
import "@/assets/cadastroQuia.css";

export default {
  data() {
    return {
      formData: {
        name: "",
        valor: "",
        pais: "",
        estado: "",
        cidade: "",
      },
      jsonDados: [],
    };
  },
  async mounted() {
    try {
      const response = await fetch('@/json/worldRegion.json');
      this.jsonDados = await response.json();
      await this.carregarJson();
    } catch (error) {
      console.error('Erro ao carregar o JSON:', error);
    }
  },
  computed: {
    filteredEstados() {
      const pais = this.jsonDados.find((p) => p.id === this.formData.pais);
      return pais ? pais.estados : [];
    },
    filteredCidades() {
      const estado = this.filteredEstados.find((e) => e.id === this.formData.estado);
      return estado ? estado.cidades : [];
    },
  },
  methods: {
    modificarJson() {
      try {
        this.parsedData = JSON.parse(this.jsonData).name;
      } catch (error) {
        console.error('Erro ao analisar o JSON:', error);
      }
    },
    handleSubmit() {
      console.log("Form Data:", this.formData);
    },
  },
};
</script>
