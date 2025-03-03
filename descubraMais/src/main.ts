import './assets/css/main.css';
import { createApp } from 'vue';
import App from './App.vue'; // Verifique se o caminho está correto
import router from './router';
import VueTheMask from 'vue-the-mask';

const app = createApp(App);


app.use(router);
app.use(VueTheMask); // Certifique-se de usar o nome correto do plugin

app.mount('#app');

