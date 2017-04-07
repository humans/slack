import axios from 'axios';
import Vue from 'vue';
import Holler from './holler';

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Slack.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
};

Vue.prototype.$http = axios;
Vue.prototype.$echo = window.echo = new Holler({
    broadcaster: 'pusher',
    key: 'aedd54192305c7a81468',
    cluster: 'ap1',
});
