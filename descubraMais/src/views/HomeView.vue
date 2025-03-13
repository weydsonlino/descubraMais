<script setup lang="ts">
import '../assets/css/HomeView.css'
import componentsCards from '@/components/componentsCards.vue'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import useAuth from '@/auth/auth.ts'

const router = useRouter()
const queryPesquisa = ref('')
const pontosTuristico = ref([])
const performSearch = () => {
  if (queryPesquisa.value.trim()) {
    router.push({ name: 'pesquisa', query: { nome: queryPesquisa.value } });
  }
};

async function axiosPontos(){
  try {
    const response = await  useAuth.axiosWithAuth('/pesquisacompleta',{method:'GET'})
    pontosTuristico.value = response
    console.log(pontosTuristico.value)
  }catch{

  }
}
onMounted(()=>{
  axiosPontos()
})
</script>
<template>
  <main>
    <div class="ilha-das-cobras">
      <input type="text" id="search-bar" placeholder="Para onde você quer ir hoje ?" v-model="queryPesquisa">
      <a href="#">
        <img class="search-icon" src="http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png"
          alt="Ícone de busca" @click="performSearch">
      </a>
    </div>

    <div class="descubra-e-compartilhe">
      Descubra e Compartilhe os Melhores Pontos Turísticos!
    </div>
    <div class="conectamos-guias-e">
      Conectamos guias e turistas para explorar o mundo juntos
    </div>

    <div class="conhea-alguns-pontos-famosos-parent">
      <div class="conhea-alguns-pontos">Conheça Alguns Pontos Famosos</div>
      <div class="container">
        <componentsCards v-for="ponto in pontosTuristico" :imagem=ponto.IMAGEM :titulo=ponto.NOME
          :descricao=ponto.INFORMACOES />
      </div>
    </div>
    <div class="rectangle-div">
      <div class="descubramais">DescubraMais</div>
      <div class="MeninaFeliz"></div>
      <div class="o-descubramais-container">
        <div class="o-descubramais">
          O DescubraMais é o seu guia perfeito para explorar os lugares mais incríveis! Aqui você encontra informações
          detalhadas sobre pontos turísticos, desde paisagens naturais e trilhas até monumentos históricos e atrações
          culturais.
        </div>
        <div class="texto">
          Planeje, explore, compartilhe <span class="textoCor">e viva momentos inesquecíveis com a gente!</span>.
        </div>
      </div>
    </div>
    <div class="por-que-escolher-nossa-platafo-parent">Por que escolher nossa plataforma?</div>

    <div class="container">
      <div class="planeta">
        <img src="@/assets/planeta.png" alt="Planeta">
        <p>Explore destinos únicos adicionados por guias locais</p>
      </div>

      <div class="Map">
        <img src="@/assets/mapa.png" alt="Mapa">
        <p>Adicione seus pontos turísticos</p>
      </div>
      <div class="estrela">
        <img src="@/assets/estrela.png" alt="Estrela">
        <p>Interaja, compartilhe experiências e receba dicas de pessoas que amam explorar o mundo, assim como você.</p>
      </div>
      <div class="amizade">
        <img src="@/assets/amizade.png" alt="Comentários">
        <p>Avaliações e comentários para encontrar os melhores lugares</p>
      </div>
    </div>
    <footer class="footer">
      <div class="footer-columns">
        <div class="footer-column">
          <h3>Idioma</h3>
          <ul>
            <li>Português do Brasil</li>
          </ul>
        </div>
        <div class="footer-column">
          <h3 class="h3_algo">Empresa</h3>
          <ul>
            <li>Sobre</li>
            <li>Empregos</li>
            <li>Marca</li>
            <li>Sala de imprensa</li>
          </ul>
        </div>
        <div class="footer-column">
          <h3 class="h3_algo">Empresa</h3>
          <ul>
            <li>Suporte</li>
            <li>Segurança</li>
            <li>Blog</li>
            <li>Comunidade</li>
          </ul>
        </div>
        <div class="footer-column">
          <h3>Política</h3>
          <h3 class="h3_algo">Política</h3>
          <ul>
            <li>Termos</li>
            <li>Privacidade</li>
            <li>Cookies</li>
          </ul>
        </div>
        <div class="footer-column">
          <h3 class="h3_algo">Aplicativo</h3>
          <ul>
            <li>Baixe para Android</li>
            <li>Baixe para iOS</li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <img src="@/assets/Logo-black.png" alt="Logo">
      </div>
    </footer>

  </main>
</template>
