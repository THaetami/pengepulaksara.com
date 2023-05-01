import './bootstrap';

import { createApp } from 'vue';
import router from './router'
import store from './Vuex';
import App from './App.vue'
import VueObserveVisibility from 'vue-observe-visibility'

createApp(App).use(store).use(router).use(VueObserveVisibility).mount('#app')
