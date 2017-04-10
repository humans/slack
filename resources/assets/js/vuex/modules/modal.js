const mutations = {
  open:  (state, component) => state.component = component,
  close: state => state.component = null,
};

export default {
  namespaced: true,

  state: {
    component: null
  },

  mutations,
};
