<template>
  <div class="container_titulo">
    <h1 class="titulo">Cadastro de Guia</h1>
    <p>Preencha as informações abaixo para se cadastrar como guia.</p>
  </div>
  <form class="cadastro-form" @submit.prevent="handleSubmit">
    <input type="text" class="input-padrao" v-mask="'$ ###,##'" v-model="formData.valor" placeholder="Valor por hora"
      required />

    <h4>Selecione suas regiões de atuação</h4>

    <select class="input-padrao" v-model="formData.pais" required :disabled="isLoadingPais">
      <option value="" disabled selected>País</option>
      <option v-for="pais in SelectPais" :key="pais.id" :value="pais.id">
        {{ pais.nome }}
      </option>
    </select>

    <select class="input-padrao" v-model="formData.estado" required :disabled="isLoadingEstados">
      <option value="" disabled selected>Estado</option>
      <option v-for="estado in jsonDadosEstados" :key="estado.id" :value="estado.id">
        {{ estado.nome }}
      </option>
    </select>

    <div class="dropdown">
      <div v-for="cidade in jsonDadosCidades" :key="cidade.id" class="checkbox-item">
        <label class="checkbox-label">
          {{ cidade.nome }}
          <input type="checkbox" :id="'cidade-' + cidade.id" :value="cidade" v-model="estados_selecionados" />
          <span class="checkmark"></span>
        </label>
      </div>
    </div>

    <div class="conteiner-Bu_Co">
      <button class="button-continuar" type="submit">Continuar</button>
    </div>
  </form>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch, defineProps } from "vue";
import axios from "axios";

const props = defineProps({
  userData: Object,
});

// Estado do formulário
const formData = ref({
  nome: props.userData?.name || "",
  cpf: props.userData?.cpf || "",
  sexo: props.userData?.gender || "",
  telefone: props.userData?.phone || "",
  senha: props.userData?.password || "",
  tipo: props.userData?.role || "",
  email: props.userData?.email || "",
  valor: "",
  rua: "maria",
  pais: "",
  estado: "",
  cidade: [],
});

// Dados das APIs
const jsonDadosPais = ref([]);
const jsonDadosEstados = ref([]);
const jsonDadosCidades = ref([]);
const estados_selecionados = ref([]);
const isEstado = ref(false);

// Buscar países, estados e cidades

const fetchPaises = async () => {
  try {
    const { data } = await axios.get("https://servicodados.ibge.gov.br/api/v1/localidades/paises/");
    console.log("Países recebidos:", data); // Verifica a estrutura dos países
    jsonDadosPais.value = data;
  } catch (error) {
    console.error("Erro ao carregar os países:", error);
  }
};


const fetchEstados = async () => {
  try {
    const { data } = await axios.get("https://servicodados.ibge.gov.br/api/v1/localidades/estados");
    jsonDadosEstados.value = data;
  } catch (error) {
    console.error("Erro ao carregar os estados:", error);
  }
};

const fetchCidades = async (estadoId: string | number) => {
  if (!estadoId) return;
  try {
    const { data } = await axios.get(
      `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`
    );
    jsonDadosCidades.value = data;
    isEstado.value = true;
  } catch (error) {
    console.error("Erro ao carregar as cidades:", error);
  } finally {
  }
};

// Envio do formulário
const handleSubmit = async () => {
  try {
    const response = await axios.post("http://localhost:8000/cadastro", formData.value);
    console.log("Resposta do servidor:", response.data);
  } catch (error) {
    console.error("Erro ao enviar os dados:", error);
  }
};

// Reatividade
watch(() => formData.value.pais, (novoPais) => {
  console.log("País selecionado:", novoPais);
});

watch(() => formData.value.estado, async (novoEstado) => {
  jsonDadosCidades.value = []; // Limpa as cidades anteriores
  await fetchCidades(novoEstado);
});

// Carregar os dados na montagem
onMounted(() => {
  fetchPaises();
  fetchEstados();
});

// Computed para selecionar países e cidades

const SelectPais = computed(() =>
  jsonDadosPais.value.map((pais: any) => ({
    id: pais.M49, // O ID correto é "M49"
    nome: pais.nome // O nome já está correto
  }))
);

const filteredCidades = computed(() =>
  jsonDadosCidades.value.filter((cidade: any) =>
    cidade.microrregiao.mesorregiao.UF.id.toString() === formData.value.estado.toString()
  )
);
</script>
