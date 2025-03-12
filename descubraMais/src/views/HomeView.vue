<script setup lang="ts">
import '../assets/css/HomeView.css'
import componentsCards from '@/components/componentsCards.vue'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const queryPesquisa = ref('')
const performSearch = () => {
  if (queryPesquisa.value.trim()) {
    router.push({ name: 'pesquisa', query: { nome: queryPesquisa.value } });
  }
};
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
        <componentsCards imagem="src/assets/maragogi.png" titulo="Maragogi - Alagoas (AL)"
          descricao="Maragogi está localizado no estado de Alagoas, no litoral nordeste do Brasil. Famoso por suas piscinas naturais e águas cristalinas, é um destino popular para mergulhos. A cidade está a cerca de 125 km de Maceió e a 135 km de Recife." />
        <componentsCards imagem="src/assets/lencois.png" titulo="Lençóis Maranhenses - Barreirinhas (MA)"
          descricao="Os Lençóis Maranhenses ficam no estado do Maranhão, no nordeste do Brasil. O acesso principal é pela cidade de Barreirinhas, que está a aproximadamente 250 km de São Luís, a capital do estado.." />
        <componentsCards imagem="src/assets/noronha.png" titulo="Fernando de Noronha (PE)"
          descricao="Fernando de Noronha é um arquipélago de Pernambuco, localizado a 350 km da costa nordeste do Brasil. Famoso por suas praias paradisíacas, oferece um ambiente único com águas cristalinas e rica vida marinha. O local é ideal para quem gosta de ecoturismo e atividades como mergulho." />
        <componentsCards imagem="src/assets/cristo.png" titulo="Cristo Redentor - Rio de Janeiro (RJ)"
          descricao="Localizado no topo do Morro do Corcovado, o Cristo Redentor fica dentro do Parque Nacional da Tijuca, no bairro do Cosme Velho, Zona Sul do Rio de Janeiro." />
        <componentsCards imagem="src/assets/cataratas.png" titulo="Cataratas do Iguaçu - Foz do Iguaçu (PR)"
          descricao="Está localizadas no Parque Nacional do Iguaçu, na cidade de Foz do Iguaçu, estado do Paraná (PR), Brasil. São um dos maiores conjuntos de quedas d'água do mundo e uma das Sete Maravilhas Naturais." />
        <componentsCards imagem="src/assets/portodegalinhas.png" titulo="Porto de Galinhas (PE)"
          descricao="Porto de Galinhas, que fica localizado no município de Ipojuca, no estado de Pernambuco (PE), a cerca de 60 km de Recife." />
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
