import './assets/main.css';
import './assets/css/HomeView.css';
import { createApp } from 'vue';
import App from './App.vue'; // Verifique se o caminho está correto
import router from './router';
import { createPinia } from 'pinia';
import VueTheMask from 'vue-the-mask';

const app = createApp(App);

const pinia = createPinia(); // Inicializar o Pinia
app.use(pinia);

app.use(router);
app.use(VueTheMask); // Certifique-se de usar o nome correto do plugin

app.mount('#app');

