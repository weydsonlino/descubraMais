<template>
  <main id="page-add-ponto-turistico">
    <h1 class="page-tittle">Cadastre o ponto turístico</h1>
    <form id="form-add-ponto-turistico">
      <section id="informacoes-basicas">
        <h2 class="section-tittle">INFORMAÇÕES BASICAS</h2>
        <div id="image-container">
          <div id="image-preview">
            <img src="../assets/addImage.png" alt="" srcset="" />
          </div>
          <p>Adicione fotos ao ponto turistico</p>
        </div>
        <label for="nome">Nome</label>
        <input type="text" name="nome" class="input" placeholder="Ex: Praça do Carmo" />
        <label for="descricao">Descrição</label>
        <textarea
          id="descricao"
          name="descricao"
          placeholder="Nos de informações sobre o que torna o local turistico, contexto historico, arquitetura e etc."
        ></textarea>
      </section>
      <section id="endereco">
        <h2 class="section-tittle">ENDEREÇO</h2>
        <div class="selects-container">
          <div class="label-select">
            <label for="pais">País</label>
            <select name="pais" class="end-select">
              <option value="none">Escolha um país</option>
              <option value="brasil">Brasil</option>
              <option value="argentina">Argentina</option>
              <option value="chile">Chile</option>
              <option value="uruguai">Uruguai</option>
            </select>
          </div>
          <div class="label-select">
            <label for="estado">Estado</label>
            <select name="estado" class="end-select">
              <option value="none">Escolha um estado</option>
              <option value="sp">São Paulo</option>
              <option value="rj">Rio de Janeiro</option>
              <option value="mg">Minas Gerais</option>
              <option value="es">Espírito Santo</option>
              <option value="pe">Pernanbuco</option>
            </select>
          </div>
          <div class="label-select">
            <label for="cidade">Cidade</label>
            <select name="cidade" class="end-select">
              <option value="none">Escolha uma cidade</option>
              <option value="Igarassu">Igarassu</option>
              <option value="Recife">Recife</option>
              <option value="Olinda">Olinda</option>
              <option value="Paulista">Paulista</option>
              <option value="Abreu e Lima">Abreu e Lima</option>
            </select>
          </div>
        </div>
        <label for="rua">Rua</label>
        <input type="text" name="rua" class="input" placeholder="Rua josé bonifacio" />
      </section>
      <section id="categorias">
        <h2 class="section-tittle">CATEGORIAS</h2>
        <input type="text" name="categoria" class="input" placeholder="Procure a categoria" />
        <div id="container-categorias-selecionadas">
          <button class="button categoria-adicionada">
            <p>Parque</p>
            <span>X</span>
          </button>
        </div>
      </section>

      <button type="submit" class="button register-button">Cadastrar</button>
    </form>
  </main>
</template>

<script setup lang="ts"></script>
