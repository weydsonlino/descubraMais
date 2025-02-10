<template>
  <div class="container">>
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
      <h3 class="titulo">Cadastro de Turista</h3>
      <p class="texto">Preencha as informações abaixo para se cadastrar como turista</p>

      <form @submit.prevent="handleSubmit">
        <h4>Selecione suas regiões de atuação</h4>

        <select class="pais" v-model="formData.pais" required>
          <option value="" disabled selected>Pais</option>
          <option v-for="pais in SelectPais" :key="pais.M49" :value="pais.M49">
            {{ this.pais = pais.nome }}
          </option>
        </select>

        <select class="estado" v-model="formData.estado" required>
          <option value="" disabled selected>Estado</option>
          <option v-for="estado in filteredEstados" :key="estado.id" :value="estado.id">
            {{ this.estado = estado.nome }}
          </option>
        </select>
        <select class="cidade" v-model="formData.cidade" required>
          <option value="" disabled selected>Cidade</option>
          <option v-for="cidade in filteredCidades" :key="cidade.id" :value="cidade.id">
            {{ this.cidade = cidade.nome }}
          </option>
        </select>
        <button class="button-continuar" type="submit">Cadastrar</button>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, watch, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useUserStore } from "../stores/user"; // Corrigido o caminho da store
import "../assets/css/cadastroTurista.css";

export default defineComponent({
  setup() {
    const userStore = useUserStore();
    const router = useRouter();

    const formData = ref({
      pais: "",
      estado: "",
      cidade: "",
    });

    const jsonDadosPais = ref([]);
    const jsonDadosEstados = ref([]);
    const jsonDadosCidades = ref([]);
    const estados = ref([]);
    const cidades = ref([]);

    const axiosPais = async () => {
      try {
        const pais = await axios.get("https://servicodados.ibge.gov.br/api/v1/localidades/paises/");
        jsonDadosPais.value = pais.data;
      } catch (error) {
        console.error("Erro ao carregar os países:", error);
      }
    };

    const axiosEstados = async () => {
      try {
        const estados = await axios.get("https://servicodados.ibge.gov.br/api/v1/localidades/estados");
        jsonDadosEstados.value = estados.data;
      } catch (error) {
        console.error("Erro ao carregar os estados:", error);
      }
    };

    const axiosCidades = async () => {
      if (!formData.value.estado) return;
      try {
        const cidades = await axios.get(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${formData.value.estado}/municipios`);
        jsonDadosCidades.value = cidades.data;
      } catch (error) {
        console.error("Erro ao carregar as cidades:", error);
      }
    };

    watch(
      () => formData.value.pais,
      (novoPais) => {
        const paisSelecionado = jsonDadosPais.value.find((pais) => pais.id === novoPais);
        estados.value = paisSelecionado ? paisSelecionado.estados || [] : [];
        formData.value.estado = "";
        formData.value.cidade = "";
        axiosEstados();
      }
    );

    watch(
      () => formData.value.estado,
      (novoEstado) => {
        const estadoSelecionado = jsonDadosEstados.value.find((estado) => estado.id === novoEstado);
        cidades.value = estadoSelecionado ? estadoSelecionado.cidades || [] : [];
        axiosCidades();
      }
    );

    const handleSubmit = () => {
      console.log("Dados do Formulário:", formData.value);
      userStore.setUserData({ ...userStore.userData, ...formData.value });
      router.push("/some-next-route"); // Redireciona para a próxima rota após o cadastro
    };

    const SelectPais = computed(() => jsonDadosPais.value.map((pais) => ({ id: pais.id, nome: pais.nome })));

    const filteredEstados = computed(() => jsonDadosEstados.value.filter((estado) => formData.value.pais ? estado.id.startsWith(formData.value.pais) : true));

    const filteredCidades = computed(() => {
      const estadoStr = formData.value.estado.toString();
      return jsonDadosCidades.value.filter((cidade) => estadoStr ? cidade.id.toString().startsWith(estadoStr) : true);
    });

    return {
      formData,
      jsonDadosPais,
      jsonDadosEstados,
      jsonDadosCidades,
      estados,
      cidades,
      SelectPais,
      filteredEstados,
      filteredCidades,
      handleSubmit,
      axiosPais,
      axiosEstados,
      axiosCidades
    };
  },
  async mounted() {
    await this.axiosPais();
    await this.axiosEstados();
  }
});
</script>
