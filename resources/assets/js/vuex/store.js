import Vue from 'vue';
import Vuex from 'vuex';
import * as actions from './actions.js';
import * as getters from './getters.js';
import * as mutations from './mutations.js';
import modules from './modules';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    modal: null,

    team: {},
    users: [],
    messages: [],
    currentUser: {},
  },

  actions,
  getters,
  mutations,
  modules,
});
