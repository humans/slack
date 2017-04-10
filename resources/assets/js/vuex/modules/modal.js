const mutations = {
  open:  (state, component) => state.modal = component,
  close: state => state.modal = null,
};

export default {
  namespaced: true,

  state: {
    component: null
  },

  mutations,
};
