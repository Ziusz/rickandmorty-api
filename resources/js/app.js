import './bootstrap';
import { createApp } from 'vue';
import mainApp from '../pages/app.vue';

const app = createApp(mainApp);
app.mount('#app');
