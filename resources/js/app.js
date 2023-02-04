import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import "./assets/css/app.css";
import Permissions from './utils/Permissions.vue';
createApp(App).use(router).mixin(Permissions).use(createPinia()).mount('#app')


