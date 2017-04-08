import _ from 'lodash';
import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';
import router from '../routes/router';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    modal: null,

    channels: [],
    messages: [],
    userSettings: null,
    currentChannel: null,
  },

  mutations: {
    openModal (state, component) {
      state.modal = component;
    },

    closeModal (state) {
      state.modal = null;
    },

    addMessage (state, message) {
      state.messages.push(message);
    },

    addChannel (state, channel) {
      state.channels.push(channel);

      state.channels = _.orderBy(state.channels, 'name');
    },

    updateUserSettings (state, settings) {
      state.userSettings = settings;
    },

    updateMessages (state, messages) {
      state.messages = messages;

      state.messages = _.orderBy(state.messages, 'created_at');
    },

    updateChannels (state, channels) {
      state.channels = channels;
    },

    selectChannel (state, channel) {
      state.currentChannel = channel;
    },
  },

  actions: {
    selectChannel ({ commit, state }, channel) {
      if (state.currentChannel) {
        echo.leave('channel.' + state.currentChannel.name);
      }

      commit('selectChannel', channel);
      commit('updateMessages', []);
      commit('closeModal');

      axios.patch(`/api/user/settings/active_channel/${channel.id}`);

      router.push({
        name: 'channel',
        params: { channel: channel.id },
      });
    },

    addChannel ({ dispatch, commit }, channel) {
      commit('addChannel', channel);

      dispatch('selectChannel', channel);
    },
  },
});
