import Vue from 'vue';
import Vuex from 'vuex';
import router from '../routes/router';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    channels: [],
    messages: [],
    currentChannel: null,
  },

  mutations: {
    addMessage (state, message) {
      state.messages.push(message);
    },

    updateMessages (state, messages) {
      state.messages = messages;
    },

    updateChannels (state, channels) {
      state.channels = channels;
    },

    selectChannel (state, channel) {
      state.currentChannel = channel;
    },
  },

  actions: {
    selectChannel (context, channel) {
      context.commit('updateMessages', []);
      context.commit('selectChannel', channel);

      router.push({
        name: 'channel',
        params: { channel: channel.id },
      });
    },
  },
});
