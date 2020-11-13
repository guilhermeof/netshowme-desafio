import VueRouter from 'vue-router';
import router from './router';
require('./bootstrap');

window.Vue = require('vue');

Vue.router = router;
Vue.use(VueRouter);

axios.defaults.baseURL = '/api/v1';

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('index', require('./Index.vue').default);

const app = new Vue({
    el: '#app',
    router
});
