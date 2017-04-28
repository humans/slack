import * as actions from './channel/actions.js';
import * as getters from './channel/getters.js';
import * as mutations from './channel/mutations.js';

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
