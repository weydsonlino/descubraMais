<template>
  <div class="container">
    <div class="left-section">
    </div>
    <div class="right-section">
      <div class="conteiner-titolo_texto">
        <h1 class="titulo">Cadastre-se</h1>
        <p class="texto">Seja um Guia ou apenas um viajante</p>
      </div>
      <form class="formPrincipal" @submit.prevent="handleSubmit">
        <input type="text" class="valor" v-mask="'$ ###,##'" v-model="formData.valor" placeholder="Valor por hora"
          required />
        <h4>Selecione suas regiões de atuação</h4>
        <p>Nome do país</p>
        <select class="pais" v-model="formData.pais" required>
          <option value="" disabled selected>Pais</option>
          <option v-for="pais in SelectPais" :key="pais.id" :value="pais.id">
            {{ pais.nome }}
          </option>
        </select>
        <div class="conteiner-estado_cidade">
          <select class="estado" v-model="formData.estado" required>
            <option value="" disabled selected>Estado</option>
            <option v-for="estado in jsonDadosEstados" :key="estado.id" :value="estado.id">
              {{ estado.nome }}
            </option>
          </select>
          <select class="cidade" v-model="formData.cidade" required>
            <option value="" disabled selected>Cidade</option>
            <option v-for="cidade in filteredCidades" :key="cidade.id" :value="cidade.id">
              {{ cidade.nome }}
            </option>
          </select>
        </div>
        <h2>Regiões selecionadas</h2>
        <AddItem />
        <ItemList />
        <div class="conteiner-Bu_Co">
          <button class="Button-Continuar" type="submit">Continuar</button>
          <router-link class="Conta" to="/login">Já tem conta? Faça login</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, computed, onMounted, watch } from "vue";
import { useUserStore } from "../stores/user";
import axios from "axios";
import VueMask from "vue-the-mask";
import "@/assets/css/cadastroGuia.css";
import AddItem from '../components/AddItem.vue';
import ItemList from '../components/ItemList.vue';

export default defineComponent({
  components: {
    VueMask,
  },
  setup() {
    const userStore = useUserStore();
    const userData = computed(() => userStore.userData);

    const formData = ref({
      valor: "",
      pais: "",
      estado: "",
      cidade: "",
    });

    const jsonDadosPais = ref([]);
    const jsonDadosEstados = ref([]);
    const jsonDadosCidades = ref([]);

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

    const axiosCidades = async (estadoId) => {
      if (!estadoId) return;
      try {
        const cidades = await axios.get(<ItemList />
          `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios`
        );
        jsonDadosCidades.value = cidades.data;
      } catch (error) {
        console.error("Erro ao carregar as cidades:", error);
      }
    };

    const handleSubmit = () => {
      console.log("Dados do Formulário:", JSON.stringify(formData.value, null, 2));
      userStore.setUserData(formData.value);
    };

    watch(
      () => formData.value.pais,
      (novoPais) => {
        console.log("País selecionado:", novoPais);
      }
    );

    watch(
      () => formData.value.estado,
      (novoEstado) => {
        axiosCidades(novoEstado);
      }
    );

    onMounted(async () => {
      await axiosPais();
      await axiosEstados();
    });

    const SelectPais = computed(() => jsonDadosPais.value.map((pais) => ({ id: pais.id, nome: pais.nome })));

    const filteredCidades = computed(() => {
      const estadoStr = formData.value.estado.toString();
      return jsonDadosCidades.value.filter((cidade) => {
        return estadoStr ? cidade.microrregiao.mesorregiao.UF.id.toString() === estadoStr : true;
      });
    });
    console.log("Dados do Formulário: ", JSON.stringify(userStore, null, 2));
    return {
      userData,
      formData,
      SelectPais,
      jsonDadosEstados,
      filteredCidades,
      handleSubmit,
      useUserStore
    };
  },
});
</script>
