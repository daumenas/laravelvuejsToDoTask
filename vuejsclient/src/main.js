import Vue from 'vue';
import App from './App.vue';
import { router } from './router';
import store from './store';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import VeeValidate from 'vee-validate';
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

Vue.config.productionTip = false;

Vue.use(VeeValidate);
Vue.component('v-select', vSelect)

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');
