import Vue from 'vue';
import VueRouter from 'vue-router';
import ChannelConversation from '../components/ChannelConversation';
import UserConversation from '../components/UserConversation';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',

    routes: [
      { path: '/' },
      { path: '/messages/@:user', name: 'user', component: UserConversation },
      { path: '/messages/:channel', name: 'channel', component: ChannelConversation },
    ],
});
