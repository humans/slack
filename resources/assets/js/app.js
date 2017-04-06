import Echo from 'laravel-echo'
import Vue from 'vue';
import axios from 'axios';
import Pusher from 'pusher-js';

Vue.use(require('vue-router'));

import router from './routes/router.js';
import store from './vuex/store.js';

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

const app = new Vue({
  router,
  store,

  el: '#app',

  data: {
    team: window.Slack.team,

    channels: [],
    messages: [],

    message: null,
    currentChannel: null,
    subscription: null,
  },

  mounted () {
    this.refresh();
  },

  methods: {
    join (channel) {
      if (this.currentChannel) {
        this.$echo.leave(this.currentChannel.name);
      }

      this.messages = [];
      this.currentChannel = channel;

      this.$http
        .get(`/api/channels/${this.currentChannel.id}`)
        .then(({ data }) => this.messages = data.latest_messages);

      this.$echo
        .private(`${this.team}.channel.${channel.name}`)
        .listen('MessageSent', ({ message }) => {
          this.messages.push(message);
        });
    },

    send () {
      this.$http
        .post(`/api/channels/${this.currentChannel.id}/messages`, { message: this.message })
        .then(({ data }) => this.messages.push(data));

      this.message = null;
    },

    refresh () {
      this.$http
        .get('/api/channels')
        .then(({ data }) => {
          this.channels = data;

          this.join(data[0]);
        });
    },
  },
});
