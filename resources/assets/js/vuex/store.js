import _ from 'lodash';
import Vue from 'vue';
import Vuex from 'vuex';
import router from '../routes/router';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    modal: null,

    team: {},
    channels: [],
    messages: [],
    currentUser: {},
    currentChannel: {},
  },

  getters: {
    joinedChannels (state, getters) {
      return state.channels.filter((channel) => channel.joined);
    },

    availableChannels (state, getters) {
      return state.channels.filter((channel) => ! channel.joined);
    },

    channelCount (state, getters) {
      return state.channels.length;
    },
  },

  mutations: {
    updateUserDetails (state, user) {
      state.currentUser = user;
    },

    updateTeam (state, team) {
      state.team = team;
    },

    openModal (state, component) {
      state.modal = component;
    },

    closeModal (state) {
      state.modal = null;
    },

    /**
     * We have to sort them since the messages are in
     * descending order when we query it from the server.
     */
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

    addMessage (state, message) {
      state.messages.push(message);
    },

    addChannel (state, channel) {
      state.channels.push(channel);

      state.channels = _.orderBy(state.channels, 'name');
    },
  },

  actions: {
    selectChannel ({ commit, state }, channel) {
      if (state.currentChannel) {
        echo.leave('channel.' + state.currentChannel.name);
      }

      commit('selectChannel', channel);
      commit('updateMessages', channel.latest_messages);
      commit('closeModal');

      echo
        .private('channel.' + state.currentChannel.name)
        .listen('MessageSent', ({ message }) => commit('addMessage', message));
    },

    addChannel ({ dispatch, commit }, channel) {
      commit('addChannel', channel);

      dispatch('selectChannel', channel);
    },
  },
});
