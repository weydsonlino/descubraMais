<template>
  <div class="container_titulo">
    <h3 class="titulo-form">Cadastro de Turista</h3>
    <p class="texto-form">prencha as informações abaixo para se cadastrar como turista</p>
  </div>
  <form class="cadastro-form" @submit.prevent="handleSubmit">
    <p class="texto-form">Selecione suas cidades/regiões de Interesse</p>

    <select class="input-padrao" v-model="formData.pais" required>
      <option value="" disabled>Pais</option>
      <option v-for="pais in SelectPais" :key="pais.M49" :value="pais.M49">{{ pais.nome }}</option>
    </select>

    <select class="input-padrao" v-model="formData.estado" required>
      <option value="" disabled>Estado</option>
      <option v-for="estado in filteredEstados" :key="estado.id" :value="estado.id">
        {{ estado.nome }}
      </option>
    </select>

    <select class="input-padrao" v-model="formData.cidade" required>
      <option value="" disabled>Cidade</option>
      <option v-for="cidade in filteredCidades" :key="cidade.id" :value="cidade.id">
        {{ cidade.nome }}
      </option>
    </select>
    <button class="button-continuar" type="submit">Continuar</button>
  </form>
</template>

<script setup lang="ts">
import { ref, watch, computed, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

// Definir propriedades e router
const router = useRouter();
const props = defineProps({
  userData: Object
});

// Inicializar o formData com valores
const formData = ref({
  nome: props.userData?.name,
  cpf: props.userData?.cpf,
  sexo: props.userData?.gender,
  telefone: props.userData?.phone,
  senha: props.userData?.password,
  tipo: props.userData?.role,
  email: props.userData?.gmail,
  rua: 'maria',
  pais: '', // Inicializando o pais vazio
  estado: '', // Inicializando o estado vazio
  cidade: ''
});

// Definir dados reativos para países, estados e cidades
const jsonDadosPais = ref([]);
const jsonDadosEstados = ref([]);
const jsonDadosCidades = ref([]);
const estados = ref([]);
const cidades = ref([]);

// Função de envio de dados
const handleSubmit = async () => {
  try {
    const response = await axios.post("http://localhost:8000/cadastro", formData.value);
    console.log("Resposta do servidor:", response.data);
  } catch (error) {
    console.error("Erro ao enviar os dados:", error);
  }
};

// Função para buscar países
const axiosPais = async () => {
  try {
    const pais = await axios.get("https://servicodados.ibge.gov.br/api/v1/localidades/paises/");
    jsonDadosPais.value = pais.data;
  } catch (error) {
    console.error("Erro ao carregar os países:", error);
  }
};

// Função para buscar estados
const axiosEstados = async () => {
  try {
    const estados = await axios.get("https://servicodados.ibge.gov.br/api/v1/localidades/estados");
    jsonDadosEstados.value = estados.data;
  } catch (error) {
    console.error("Erro ao carregar os estados:", error);
  }
};

// Função para buscar cidades
const axiosCidades = async () => {
  if (!formData.value.estado) return;
  try {
    const cidades = await axios.get(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${formData.value.estado}/municipios`);
    jsonDadosCidades.value = cidades.data;
  } catch (error) {
    console.error("Erro ao carregar as cidades:", error);
  }
};

// Watch para o país selecionado
watch(
  () => formData.value.pais,
  (novoPais) => {
    if (novoPais) {
      console.log(novoPais);
      console.log(estado);
      estados.value = jsonDadosEstados.value.filter((estado) => estado.id.toString().startsWith(novoPais));
    }
  }
);

// Watch para o estado selecionado
watch(
  () => formData.value.estado,
  (novoEstado) => {
    if (novoEstado) {
      cidades.value = jsonDadosCidades.value.filter((cidade) => cidade.id.toString().startsWith(novoEstado));
      axiosCidades(); // Chama para atualizar as cidades
    }
  }
);

// Computed para os países
const SelectPais = computed(() => jsonDadosPais.value.map((pais) => ({ M49: pais.M49, nome: pais.nome })));

// Computed para filtrar os estados com base no país
const filteredEstados = computed(() => jsonDadosEstados.value.filter((estado) => formData.value.pais ? estado.id.startsWith(formData.value.pais) : true));

// Computed para filtrar as cidades com base no estado
const filteredCidades = computed(() => {
  const estadoStr = formData.value.estado.toString();
  return jsonDadosCidades.value.filter((cidade) => estadoStr ? cidade.id.toString().startsWith(estadoStr) : true);
});

// Chama as funções para carregar os dados ao montar o componente
onMounted(async () => {
  await axiosPais();
  await axiosEstados();
});
</script>
