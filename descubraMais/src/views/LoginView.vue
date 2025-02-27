<template>
  <div>
    <div class="container">
      <div class="<img> foto-de-login"></div>
      <div class="form-section">
        <h1>Login</h1>
        <p>Preencha as informações abaixo para entrar como guia ou turista</p>
        <form @submit.prevent="login">
          <div class="form-group">
            <label for="email">Digite seu e-mail</label>
            <input type="email" v-model="email" id="email" placeholder="Digite seu e-mail" />
          </div>
          <div class="form-group">
            <label for="password">Digite sua senha</label>
            <input type="password" v-model="password" id="password" placeholder="Digite sua senha" />
          </div>
          <button type="submit">Entrar</button>
          <router-link to="/cadastro">Não tem uma conta? Cadastre-se agora!</router-link>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    login() {
      // Aqui vai a lógica de autenticação
      console.log('Email:', this.email);
      console.log('Password:', this.password);
    }
  }
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.container {
  width: 80%;
  max-width: 1200px;
  display: flex;
  background-color: white;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.image-section {
  flex: 1;
  background-image: url('https://via.placeholder.com/600x800');
  /* Substituir pelo caminho correto */
  background-size: cover;
  background-position: center;
}

.form-section {
  flex: 1;
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.form-section h1 {
  color: #333;
  margin-bottom: 20px;
}

.form-section p {
  color: #555;
  margin-bottom: 30px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  color: #555;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}

.form-group input:focus {
  outline: none;
  border-color: #007bff;
}

.form-section button {
  padding: 10px;
  border: none;
  background-color: #ff7e00;
  color: white;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.form-section button:hover {
  background-color: #e86c00;
}

.form-section a {
  color: #007bff;
  text-decoration: none;
  margin-top: 10px;
  display: inline-block;
}

.form-section a:hover {
  text-decoration: underline;
}

.navbar {
  position: absolute;
  top: 0;
  width: 100%;
  background-color: #004c99;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
}

.navbar a {
  color: white;
  text-decoration: none;
  margin: 0 10px;
}

.navbar a:hover {
  text-decoration: underline;
}
</style>

