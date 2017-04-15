import Vue from 'vue';
import VueRouter from 'vue-router';
import ChannelConversation from '../components/ChannelConversation';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',

    routes: [
      { path: '/' },
      { path: '/messages/:channel', name: 'channel', component: ChannelConversation },
      // { path: '/messages/@:user', name: 'user', component: Conversation },
    ],
});
