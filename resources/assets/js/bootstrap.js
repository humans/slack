import axios from 'axios';
import Vue from 'vue';
import Holler from './holler';

axios.defaults.headers.common = {
  'X-CSRF-TOKEN': window.Slack.csrfToken,
  'X-Requested-With': 'XMLHttpRequest',
};

/*
 * We're binding axios, and echo to the window since Laravel Echo
 * depends heavily on them being bound there.
 *
 * Now moment, we're binding it just because I wanna run some tests from
 * the console 'cause I'm lazy.
 */
Vue.prototype.$moment = window.moment = require('moment');
Vue.prototype.$http = window.axios = axios;
Vue.prototype.$echo = window.echo = new Holler({
  broadcaster: 'pusher',
  key: 'aedd54192305c7a81468',
  cluster: 'ap1',
});

