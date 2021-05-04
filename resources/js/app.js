require('./bootstrap');
window.Vue = require('vue');

/** import vue router to load all dynemics route */
import router from './router'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);
import common from './common';
Vue.mixin(common);
import store from './store';
// import CKEditor from '@ckeditor/ckeditor5-vue';
// Vue.use( CKEditor );



Vue.component('mainapp', require('./components/mainapp.vue').default);
Vue.component('adminapp', require('./components/adminapp.vue').default);
const app = new Vue({
    el: '#app',
    router,
    store
});
