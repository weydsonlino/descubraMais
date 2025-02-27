<template>
  <div class="container">
    <div class="left-section">
      <form class="formPrincipal" @submit.prevent="handleSubmit">
        <h4 class="tex">Selecione suas cidades/regiões de Interesse</h4>

        <select class="pais" v-model="formData.pais" required>
          <option value="" disabled selected>Pais</option>
          <option v-for="pais in SelectPais" :key="pais.M49" :value="pais.M49">
            {{ pais.nome }}
          </option>
        </select>

        <select class="estado" v-model="formData.estado" required>
          <option value="" disabled selected>Estado</option>
          <option v-for="estado in filteredEstados" :key="estado.id" :value="estado.id">
            {{ estado.nome }}
          </option>
        </select>
        <select class="cidade" v-model="formData.cidade" required>
          <option value="" disabled selected>Cidade</option>
          <option v-for="cidade in filteredCidades" :key="cidade.id" :value="cidade.id">
            {{ cidade.nome }}
          </option>
        </select>

        <AddItem :pais="formData.pais" :estado="formData.estado" :cidade="formData.cidade" />
        <ItemList />

        <div class="conteiner-Bu_Co">
          <button class="Button-Continuar" type="submit">Continuar</button>
          <router-link class="Conta" to="/login">Já tem conta? Faça login</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, computed, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useUserStore } from "../../stores/user"; // Corrigido o caminho da store
import "../../assets/css/cadastroTurista.css";

import AddItem from '../componentsGuia/AddItem.vue';
import ItemList from '../componentsGuia/ItemList.vue';

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

onMounted(async () => {
  await axiosPais();
  await axiosEstados();
});
</script>
