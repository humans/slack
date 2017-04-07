import axios from 'axios';
import Echo from 'laravel-echo'
import VueRouter from 'vue-router';
import Vue from 'vue';
import Pusher from 'pusher-js';
import AppView from './components/AppView';

import router from './routes/router';
import store from './vuex/store';

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Slack.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
};

Vue.prototype.$http = axios;
Vue.prototype.$echo = new Echo({
    broadcaster: 'pusher',
    key: 'aedd54192305c7a81468',
    cluster: 'ap1',
});

Vue.component('sidebar', require('./components/Sidebar'));
Vue.component('conversation', require('./components/Conversation'));
Vue.component('chatbox', require('./components/Chatbox'));

const app = new Vue({
  router,
  store,
  render: createElement => createElement(AppView),
});

app.$mount('#app');
