import Vue from 'vue';
import VueRouter from 'vue-router';
import Conversation from '../components/Conversation';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',

    routes: [
      { path: '/' },
      { path: '/messages/:channel', name: 'channel', component: Conversation },
      { path: '/messages/@:user', name: 'user', component: Conversation },
    ],
});
