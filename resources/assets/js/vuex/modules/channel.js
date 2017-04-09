import _ from 'lodash';

const state = {
  channels: [],
  current: {},
};

const mutations = {
  refresh: (state, channels) => state.channels = channels,

  select: (state, channel) => state.current = channel,

  add: (state, channel) => {
    state.channels.push(channel);

    state.channels = _.orderBy(state.channels, 'name');
  },
};

const getters = {
  joined:    state => state.channels.filter(channel => channel.joined),
  available: state => state.channels.filter(channel => ! channel.joined),
  total:     state => state.channels.length,
};

const actions = {
  select: ({ commit, state }, channel) => {
    if (state.current) {
      window.echo.leave('channel.' + state.current.name);
    }

    commit('select', channel);
    commit('updateMessages', channel.latest_messages, { root: true });
    commit('closeModal', null, { root: true });

    window.echo
      .private('channel.' + state.current.name)
      .listen('MessageSent', ({ message }) => commit('addMessage', message, { root: true }));
  },

  add: ({ dispatch, commit }, channel) => {
    commit('add', channel);

    dispatch('select', channel);
  },
};

export default {
  namespaced: true,

  state,
  getters,
  actions,
  mutations,
};
