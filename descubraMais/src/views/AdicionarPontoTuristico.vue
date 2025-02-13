<script setup lang="ts">
import InputComponent from '@/components/InputComponent.vue'
import axios from "axios";
import { ref, watch, onMounted} from "vue";
import { useRouter } from 'vue-router'

const router = useRouter();
const form = ref({
  nome: '',
  tipoPontoTuristicoId: '',
  informacoes:'',
  pais: '',
  cidade: '',
  estado: '',
  rua: '',
  user:''
})

//Variaveis para receber os dados da API
const tipos = ref<{ id: number; nome: string }[]>([]);
const paises = ref<{ id: string; nome: string }[]>([]);
const estados = ref<{ id: string; nome: string }[]>([]);
const cidades = ref<{ id: string; nome: string }[]>([]);

//Pegandos tipos existentes no banco de dados, é necessário um cadastramento previo
async function axiosTipos(){
  try{
    const response = await axios.get('http://localhost:8000/tipopontoturistico');
    tipos.value = response.data.data;
    console.log(tipos.value);
  }catch (error){
    console.error("Erro ao carregar os tipos:", error);
  }
}
//Funções que acessam e pegam os dados da API do IBGE, só possui estado e cidade do Brasil
async function axiosPais() {
  try {
    const response = await axios.get("https://servicodados.ibge.gov.br/api/v1/localidades/paises");
    paises.value = response.data;
  } catch (error) {
    console.error("Erro ao carregar os países:", error);
  }
}
async function axiosEstados() {
  if (!form.value.pais) return;
  try {
    const response = await axios.get("https://servicodados.ibge.gov.br/api/v1/localidades/estados");
    estados.value = response.data;
  } catch (error) {
    console.error("Erro ao carregar os estados:", error);
  }
}
// Essa de cidades pega a cidade de acordo com o estado selecionado
async function axiosCidades() {
  if (!form.value.estado) return;
  // Esse methodo abaixo funciona para pegar o estado que foi selecionado permitindo assim posteriomente pegar o id do estado e usar na requisição
  const estadoSelecionado = estados.value.find(e => e.nome === form.value.estado);
  if (!estadoSelecionado) return;
  try {
    const response = await axios.get(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoSelecionado.id}/municipios`);
    cidades.value = response.data;
  } catch (error) {
    console.error("Erro ao carregar as cidades:", error);
  }
}
//Observadores para carregar estados e cidades dinamicamente, parecido com UseEffect do React
watch(() => form.value.pais, axiosEstados);
watch(() => form.value.estado, axiosCidades);

// Chama as funções ao montar o componente
onMounted(()=>{
  axiosPais();
  axiosTipos();
});

//Envia os dados para a API
function handleSubmit() {
  //Esse é um cpf de um usuário que já está cadastrado no banco de dados, é necessário um cadastramento previo
  form.value.user = "89512582031"
  axios.post('http://localhost:8000/pontoturistico', form.value)
    .then(() => {
      router.push('/')
    })
    .catch((error) => {
      console.error('Erro ao cadastrar ponto turistico:', error);
    });
}

</script>

<template>
  <div class="container">
    <div class="left-section">

    </div>
    <div class="right-section">
      <div class="form-header">
        <h3 class="titulo">Cadastre o seu Ponto Turistico</h3>
        <p class="texto">Preencha as informações abaixo para adicionar um ponto turistico</p>
      </div>
      <form @submit.prevent="handleSubmit">
        <InputComponent name="nome" placeholder="Nome do Ponto Turistico" type="text" v-model="form.nome"/>
        <InputComponent name="informacoes" placeholder="Descrava o Ponto Turistico" type="text" v-model="form.informacoes"/>
        <select class="select-maior" v-model="form.tipoPontoTuristicoId">
          <option value="" disabled selected>Selecione o tipo</option>
          <option  v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">
            {{ tipo.nome }}
          </option>
        </select>
        <div class="container-endereco">
          <select v-model="form.pais">
            <option value="" disabled selected>Selecione o país</option>
            <option v-for="pais in paises" :key="pais.id" :value="pais.nome">
              {{ pais.nome }}
            </option>
          </select>
          <select v-model="form.estado" :disabled="!form.pais">
            <option value="" disabled selected>Selecione um estado</option>
            <option v-for="estado in estados" :key="estado.id" :value="estado.nome">
              {{ estado.nome }}
            </option>
          </select>

          <!-- Select de Cidades -->
          <select v-model="form.cidade" :disabled="!form.estado">
            <option value="" disabled selected>Selecione uma cidade</option>
            <option v-for="cidade in cidades" :key="cidade.id" :value="cidade.nome">
              {{ cidade.nome }}
            </option>
          </select>
        </div>
        <InputComponent name="Rua" placeholder="Informe a Rua" type="text" v-model="form.rua"/>

        <button class="button-continuar" type="submit">Cadastrar</button>
      </form>
    </div>
  </div>
  <div>
  </div>
</template>
<style scoped>

.container {
  margin: 4% 9%;
  display: flex;
  height: 105vh;
  font-family: 'Khmer', sans-serif;
  justify-content: flex-end;
}
.left-section {
  flex: 1;
  background-image: url('../assets/pontoTuristicoImage.png');
  background-size: cover;
  background-position: center;
  padding: 2rem;
}
.right-section {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  align-items: center;
  gap: 40px;
  padding: 3rem;
  background: #fff;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}
form {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.button-continuar {
  background-color: #F57C00;
  color:black;
  border: none;
  width: 250px;
  height: 40px;
  margin-top: 50px;
  border-radius: 25px;
  padding: 5px 50px;
  text-align: center;
  font-size: 20px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
}
button:hover {
  background-color: #e0a800;
}
.form-header{
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}
.titulo {
  color: #000;
  text-align: center;
  font-family: Roboto,serif;
  font-size: 32px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
}

.texto {
  color: rgba(0, 0, 0, 0.85);
  text-align: center;
  font-family: Roboto,serif;
  font-size: 13px;
  font-style: normal;
  font-weight: 300;
  line-height: normal;
}
 select{
   display: flex;
   width: 140px;
   height: 41px;
   padding: 0 8px;
   margin-bottom: 20px;
   align-items: center;
   gap:-48px;
   border-radius: 14px;
   border: 1px solid #FFF;
   background: #FFF;
   box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.25);
   color: #828181;
   font-family: Roboto,serif;
   font-size: 14px;
   font-style: normal;
   font-weight: 200;
   line-height: 150%; /* 21px */
   letter-spacing: -0.154px;
 }
 .select-maior{
   width: 456px;
   height: 41px;
 }
option{
  color: #828181;
  font-family: Roboto,serif;
  font-size: 14px;
  font-style: normal;
  font-weight: 200;
  line-height: 150%; /* 21px */
  letter-spacing: -0.154px;
}
.container-endereco{
  display: flex;
  gap: 18px;
}
</style>
