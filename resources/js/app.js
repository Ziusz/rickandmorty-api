import './bootstrap';
import { createApp } from 'vue';
import mainApp from '../pages/home.vue';

const app = createApp(mainApp);
app.mount('#app');
