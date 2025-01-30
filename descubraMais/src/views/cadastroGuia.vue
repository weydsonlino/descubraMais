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
        <input type="text" class="valor" v-mask="'$ ##.###.##'" v-model="formData.valor" placeholder="Valor por hora"
          required />

        <h4>Selecione suas regiões de atuação</h4>
        <p>Nome do país</p>
        <select class="pais" v-model="formData.pais" required>
          <option value="" disabled selected>Pais</option>
          <option v-for="pais in SelectPais" :key="pais.M49" :value="pais.M49">
            {{ this.pais = pais.nome }}
          </option>
        </select>
        <p>Nome do estado</p>
        <select class="estado" v-model="formData.estado" required>
          <option value="" disabled selected>Estado</option>
          <option v-for="estado in filteredEstados" :key="estado.id" :value="estado.id">
            {{ this.estado = estado.nome }}
          </option>
        </select>
        <p>Nome da cidade</p>
        <select class="cidade" v-model="formData.cidade" required>
          <option value="" disabled selected>Cidade</option>
          <option v-for="cidade in filteredCidades" :key="cidade.id" :value="cidade.id">
            {{ this.cidade = cidade.nome }}
          </option>
        </select>
        <button class="button-continua" type="submit">Cadastrar</button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import VueMask from "vue-the-mask";
import "@/assets/cadastroQuia.css";
import { useUserStore } from 'pinia'
import axios from "axios";

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
      jsonDadosPais: [],
      jsonDadosEstados: [],
      jsonDadosCidades: [],
      estados: [],
      cidades: [],
    };
  },
  async mounted() {
    await this.axiosPais();
    await this.axiosEstados();
  },
  watch: {
    "formData.pais"(novoPais) {
      const paisSelecionado = this.jsonDadosPais.find(
        (pais) => pais.id === novoPais
      );
      this.estados = paisSelecionado ? paisSelecionado.estados || [] : [];
      this.formData.estado = "";
      this.formData.cidade = "";
    },
    "formData.estado"(novoEstado) {
      const estadoSelecionado = this.jsonDadosEstados.find(
        (estado) => estado.id === novoEstado
      );
      this.cidades = estadoSelecionado ? estadoSelecionado.cidades || [] : [];
      this.axiosCidades();
    },
  },
  methods: {
    handleSubmit() {
      console.log("Dados do Formulário:", this.formData);
    },
    async axiosPais() {
      try {
        const pais = await axios.get(
          "https://servicodados.ibge.gov.br/api/v1/localidades/paises/");
        this.jsonDadosPais = pais.data;
      } catch (error) {
        console.error("Erro ao carregar os países:", error);
      }
    },
    async axiosEstados() {
      try {
        const estados = await axios.get(
          "https://servicodados.ibge.gov.br/api/v1/localidades/estados"
        );
        this.jsonDadosEstados = estados.data;
      } catch (error) {
        console.error("Erro ao carregar os estados:", error);
      }
    },
    async axiosCidades() {
      if (!this.formData.estado) return;
      try {
        const cidades = await axios.get(
          `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${this.formData.estado}/municipios`
        );
        this.jsonDadosCidades = cidades.data;
      } catch (error) {
        console.error("Erro ao carregar as cidades:", error);
      }
    },
  },
  computed: {
    SelectPais() {
      return this.jsonDadosPais.map((pais) => ({
        id: pais.id,
        nome: pais.nome,
      }));
    },
    filteredEstados() {
      return this.jsonDadosEstados.filter((estado) =>
        this.formData.pais ? estado.id.startsWith(this.formData.pais) : true
      );
    },
    filteredCidades() {
      // Certifique-se de que o estado é uma string
      const estadoStr = this.formData.estado.toString();

      // Filtre as cidades com base no estado
      return this.jsonDadosCidades.filter((cidade) => {
        // Se estadoStr não estiver vazio, verifique se o id da cidade começa com estadoStr
        // Caso contrário, retorne todas as cidades (quando estadoStr for vazio)
        return estadoStr ? cidade.id.toString().startsWith(estadoStr) : true;
      });


    },
  },
};
</script>
