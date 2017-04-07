import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';
import router from '../routes/router';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    channels: [],
    messages: [],
    userSettings: null,
    currentChannel: null,
  },

  mutations: {
    addMessage (state, message) {
      state.messages.push(message);
    },

    updateUserSettings (state, settings) {
      state.userSettings = settings;
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
      context.commit('selectChannel', channel);
      context.commit('updateMessages', []);

      axios.patch(`/api/user/settings/active_channel/${channel.id}`);

      router.push({
        name: 'channel',
        params: { channel: channel.id },
      });
    },
  },
});
