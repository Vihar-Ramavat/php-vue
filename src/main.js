import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import "./assets/app.css";
import $ from "jquery";
window.$ = $;
window.jQuery = $;
createApp(App).use(router).mount('#app')