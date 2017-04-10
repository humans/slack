import * as actions from './actions.js';
import * as getters from './getters.js';
import * as mutations from './mutations.js';

export default {
  namespaced: true,

  state: {
    channels: [],
    current: {},
  },

  actions,
  getters,
  mutations,
};
