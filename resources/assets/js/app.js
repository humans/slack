import VueRouter from 'vue-router';
import Vue from 'vue';
import Pusher from 'pusher-js';
import AppView from './components/AppView';

require('./bootstrap');

import router from './routes/router';
import store from './vuex/store';

const app = new Vue({
  router,
  store,
  render: createElement => createElement(AppView),
});

app.$mount('#app');
