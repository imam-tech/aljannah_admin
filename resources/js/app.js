import Vue from 'vue'
import router from './src/routers/router.js'
import App from './src/App.vue'
import store from './src/store/store.js'
import './src/plugins/axios.js'
import './src/plugins/vuesax.js'
import './src/plugins/filter.js'
import Pagination from 'vue-pagination-2';

Vue.component('pagination', Pagination);
new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')