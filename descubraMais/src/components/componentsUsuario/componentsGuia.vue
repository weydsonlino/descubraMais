<template>
  <div class="conteiner-titolo_texto">
    <h1 class="titulo">Cadastre-se</h1>
    <p class="texto">Seja um Guia ou apenas um viajante</p>
  </div>
  <form class="formPrincipal" @submit.prevent="handleSubmit">
    <input type="text" class="input-padrao" v-mask="'$ ###,##'" v-model="formData.valor" placeholder="Valor por hora"
      required />
    <h4>Selecione suas regiões de atuação</h4>
    <p>Nome do país</p>
    <select class="input-padrao" v-model="formData.pais" required>
      <option value="" disabled selected>Pais</option>
      <option v-for="pais in SelectPais" :key="pais.id" :value="pais.id">
        {{ pais.nome }}
      </option>
    </select>
    <div class="conteiner-estado_cidade">
      <select class="input-padrao" v-model="formData.estado" required>
        <option value="" disabled selected>Estado</option>
        <option v-for="estado in jsonDadosEstados" :key="estado.id" :value="estado.id">
          {{ estado.nome }}
        </option>
      </select>
      <select class="input-padrao" v-model="formData.cidade" required>
        <option value="" disabled selected>Cidade</option>
        <option v-for="cidade in filteredCidades" :key="cidade.id" :value="cidade.id">
          {{ cidade.nome }}
        </option>
      </select>
    </div>
    <h2>Regiões selecionadas</h2>
    <AddItem :pais="formData.pais ? JSON.stringify(formData.pais) : ''" :estado="String(formData.estado || '')"
      :cidade="String(formData.cidade || '')" />
    <ItemList />
    <div class="conteiner-Bu_Co">
      <button class="button-continuar" type="submit">Continuar</button>
      <button v-on:click="refazer" class="refazer">refazer cadastro</button>
    </div>
  </form>

</template>
<script setup lang="ts">
import { ref, computed, onMounted, watch } from "vue";
import axios from "axios";
import VueMask from "vue-the-mask";

const props = defineProps({
  userData: Object
});
// Estado do formulário
const formData = ref({
  nome: props.userData?.name,
  cpf: props.userData?.cpf,
  sexo: props.userData?.gender,
  telefone: props.userData?.phone,
  senha: props.userData?.password,
  tipo: props.userData?.role,
  email: props.userData?.email,
  rua: 'maria',
  pais: '', // Inicializando o pais vazio
  estado: '', // Inicializando o estado vazio
  cidade: ''
});

// Dados das APIs
const jsonDadosPais = ref([]);
const jsonDadosEstados = ref([]);
const jsonDadosCidades = ref([]);

//refazer os dados
const refazer = () => {
  window.location.reload();
}
const handleSubmit = async () => {
  try {
    const response = await axios.post("http://localhost:8000/cadastro", formData.value);
    console.log("Resposta do servidor:", response.data);
  } catch (error) {
    console.error("Erro ao enviar os dados:", error);
  }
};
// Funções para buscar dados externos
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
  } catch (error) {
    console.error("Erro ao carregar as cidades:", error);
  }
};

// Reatividade
watch(() => formData.value.pais, (novoPais) => {
  console.log("País selecionado:", novoPais);
});

watch(() => formData.value.estado, (novoEstado) => {
  fetchCidades(novoEstado);
});

// Carregar os dados na montagem
onMounted(() => {
  fetchPaises();
  fetchEstados();
});

// Computed para selecionar países e cidades
const SelectPais = computed(() =>
  jsonDadosPais.value.map((pais: any) => ({ id: pais.id, nome: pais.nome }))
);

const filteredCidades = computed(() =>
  jsonDadosCidades.value.filter((cidade: any) =>
    formData.value.estado ? cidade.microrregiao.mesorregiao.UF.id.toString() === formData.value.estado.toString() : true
  )
);
</script>
