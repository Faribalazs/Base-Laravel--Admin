import axios from 'axios';
window.axios = axios;

import { createApp } from 'vue'
import NewPonuda from './components/NewPonuda.vue'
import Dropdown from './components/Dropdown.vue'

import 'sweetalert2/dist/sweetalert2.min.css';

const VueApp = createApp({
    el: '#app',
});

VueApp.component('new-ponuda', NewPonuda);
VueApp.component('dropdown', Dropdown);

VueApp.mount('#app');