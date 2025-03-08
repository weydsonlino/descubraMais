<template>
  <h1 class="titulo">Cadastre-se</h1>
  <p class="texto">Seja um Guia ou apenas um viajante</p>
  <form class="cadastro-form" @submit.prevent="handleSubmit">
    <input type="text" class="input-padrao" v-mask="'$ ###,##'" v-model="formData.valor" placeholder="Valor por hora"
      required />

    <h4>Selecione suas regiões de atuação</h4>

    <!-- País -->
    <select class="input-padrao" v-model="formData.pais" required :disabled="isLoadingPais">
      <option value="" disabled selected>País</option>
      <option v-for="pais in SelectPais" :key="pais.id" :value="pais.id">
        {{ pais.nome }}
      </option>
    </select>
    <p v-if="isLoadingPais">Carregando países...</p>

    <!-- Estado -->
    <div class="container_lado-a-lado">
      <select class="input_lado-a-lado" v-model="formData.estado" required :disabled="isLoadingEstados">
        <option value="" disabled selected>Estado</option>
        <option v-for="estado in jsonDadosEstados" :key="estado.id" :value="estado.id">
          {{ estado.nome }}
        </option>
      </select>
      <p v-if="isLoadingEstados">Carregando estados...</p>

      <!-- Cidade -->
      <select class="input_lado-a-lado" @change="addCidades">
        <option value="" disabled selected>Cidade</option>
        <option v-for="cidade in filteredCidades" :key="cidade.id" :value="cidade.id">
          {{ cidade.nome }}
        </option>
      </select>
      <p v-if="isLoadingCidades">Carregando cidades...</p>
    </div>
    <h2>Regiões selecionadas</h2>
    <div class="dropdown">
      <div>
        <li class="li_text" v-for="(ponto, index) in estados_selecionados" :key="index">
          {{ ponto.nome }}
          <!-- Adicionando o ícone de "x" -->
          <button type="button" @click="removeCidades(ponto.id)" class="remove-btn">x</button>
        </li>
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

// Adicionar cidades selecionadas
const addCidades = (event: Event) => {
  const cidadeId = (event.target as HTMLSelectElement).value;
  const selectedCidade = jsonDadosCidades.value.find(cidade => cidade.id.toString() === cidadeId);

  if (selectedCidade && !estados_selecionados.value.some(cidade => cidade.id === selectedCidade.id)) {
    estados_selecionados.value.push(selectedCidade);
    formData.value.cidade.push(selectedCidade); // Adiciona a cidade no formData
  }
};

// deleta cidades selecionadas
const removeCidades = (cidadeId: number) => {
  const cidadeIndex = estados_selecionados.value.findIndex(cidade => cidade.id === cidadeId);
  if (cidadeIndex !== -1) {
    estados_selecionados.value.splice(cidadeIndex, 1);
    formData.value.cidade = formData.value.cidade.filter(cidade => cidade.id !== cidadeId);
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
  jsonDadosPais.value.map((pais: any) => ({ id: pais.id, nome: pais.nome.abreviado }))
);

const filteredCidades = computed(() =>
  jsonDadosCidades.value.filter((cidade: any) =>
    cidade.microrregiao.mesorregiao.UF.id.toString() === formData.value.estado.toString()
  )
);
</script>


<style scoped>
.remove-btn {
  background: none;
  border: none;
  color: red;
  font-size: 16px;
  cursor: pointer;
  margin-left: 10px;
}

.remove-btn:hover {
  color: darkred;
}
</style>
