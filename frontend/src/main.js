import { createApp } from 'vue'
import './style.css'
import './timeline.css'
import Vue3Lottie from 'vue3-lottie'
import App from './App.vue'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import 'bootstrap-icons/font/bootstrap-icons.css'
import '@fortawesome/fontawesome-free/css/all.min.css'
import router from "./routes";

createApp(App).use(router).use(Vue3Lottie).mount('#app')