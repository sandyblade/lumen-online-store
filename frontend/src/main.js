import { createApp } from 'vue'
import './style.css'
import './timeline.css'
import Vue3Lottie from 'vue3-lottie'
import App from './App.vue'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import 'bootstrap-icons/font/bootstrap-icons.css'
import '@fortawesome/fontawesome-free/css/all.min.css'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import router from "./routes";

createApp(App).use(router).use(Vue3Lottie).use(VueSweetalert2).mount('#app')