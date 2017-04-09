import Vue from 'vue';
import Vuex from 'vuex';
import * as actions from './actions.js';
import * as getters from './getters.js';
import * as mutations from './mutations.js';

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

  actions,
  getters,
  mutations,
});
