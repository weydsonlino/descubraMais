<script setup lang="ts">
import InputComponent from '@/components/InputComponent.vue'
import axios from 'axios'
import { ref, watch, onMounted, resolveDirective } from 'vue'
import { useRouter } from 'vue-router'
import AdicionarFotos from '@/components/AdicionarFotos.vue'
import useAuth from '@/auth/auth.ts'
import PopUpComponent from '@/components/PopUpComponent.vue'

const router = useRouter()
const formData = new FormData()
const form = ref({
  nome: '',
  tipoPontoTuristicoId: '',
  informacoes: '',
  pais: '',
  cidade: '',
  estado: '',
  rua: '',
  user: '',
  imagens: []
})

//Variaveis para receber os dados da API
const tipos = ref<{ id: number; nome: string }[]>([])
const paises = ref<{ id: string; nome: string }[]>([])
const estados = ref<{ id: string; nome: string }[]>([])
const cidades = ref<{ id: string; nome: string }[]>([])
//Variaveis para o popup
const state = ref({})
const type = ref('')
const show = ref(false)

//Pegandos tipos existentes no banco de dados, é necessário um cadastramento previo
async function axiosTipos() {
  try {
    const response = await useAuth.axiosWithAuth('/tipospontosturisticos')
    tipos.value = response.data
    console.log(tipos.value)
  } catch (error) {
    console.error('Erro ao carregar os tipos:', error)
  }
}
//Funções que acessam e pegam os dados da API do IBGE, só possui estado e cidade do Brasil
async function axiosPais() {
  try {
    const response = await axios.get('https://servicodados.ibge.gov.br/api/v1/localidades/paises')
    paises.value = response.data
  } catch (error) {
    console.error('Erro ao carregar os países:', error)
  }
}
async function axiosEstados() {
  if (!form.value.pais) return
  try {
    const response = await axios.get('https://servicodados.ibge.gov.br/api/v1/localidades/estados')
    estados.value = response.data
  } catch (error) {
    console.error('Erro ao carregar os estados:', error)
  }
}
// Essa de cidades pega a cidade de acordo com o estado selecionado
async function axiosCidades() {
  if (!form.value.estado) return
  // Esse methodo abaixo funciona para pegar o estado que foi selecionado permitindo assim posteriomente pegar o id do estado e usar na requisição
  const estadoSelecionado = estados.value.find((e) => e.nome === form.value.estado)
  if (!estadoSelecionado) return
  try {
    const response = await axios.get(
      `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoSelecionado.id}/municipios`,
    )
    cidades.value = response.data
  } catch (error) {
    console.error('Erro ao carregar as cidades:', error)
  }
}
function statesPopUp(){
  if (state.value.sucess == true){
    show.value = true
    type.value = 'success'
  }
}
  //Observadores para carregar estados e cidades dinamicamente, parecido com UseEffect do React
  watch(() => form.value.pais, axiosEstados)
  watch(() => form.value.estado, axiosCidades)

  // Chama as funções ao montar o componente
  onMounted(() => {
    axiosPais()
    axiosTipos()
  })

  //Envia os dados para a API
  async function handleSubmit() {
    console.log(form.value)
    try {
      const response = await useAuth.axiosWithAuth('/pontosturisticos', {
        method: 'POST',
        data: form.value,
      })
      state.value = response
      statesPopUp()
      //router.push('/')
    } catch (error) {
      console.log(error)
    }
  }
</script>

<template>
  <PopUpComponent :message=state.message :show=show :type=type />
  <div class="cadastro-container">
    <div class="left-section"></div>
    <div class="right-section">
      <div class="form-header">
        <h3 class="titulo-form">Cadastre o seu Ponto Turistico</h3>
        <p class="texto-form">Preencha as informações abaixo para adicionar um ponto turistico</p>
      </div>
      <form @submit.prevent="handleSubmit" class="cadastro-form">
        <InputComponent
          name="nome"
          placeholder="Nome do Ponto Turistico"
          type="text"
          v-model="form.nome"
        />
        <InputComponent
          name="informacoes"
          placeholder="Descrava o Ponto Turistico"
          type="text"
          v-model="form.informacoes"
        />
        <select class="select-maior" v-model="form.tipoPontoTuristicoId">
          <option value="" disabled selected>Selecione o tipo</option>
          <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">
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
        <InputComponent name="Rua" placeholder="Informe a Rua" type="text" v-model="form.rua" />

        <h2 class="sub-titulo-form">Adicione Fotos</h2>
        <AdicionarFotos v-model="form.imagens" />
        <div class="button-container">
          <button class="button-continuar" type="submit">Cadastrar</button>
        </div>
      </form>
    </div>
  </div>
</template>
<style scoped>
.container-endereco {
  display: flex;
  gap: 18px;
}
.left-section {
  background-image: url('../assets/imagem_ponto_turisticos.png');
}
</style>
