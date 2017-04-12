export const select = ({ commit, state }, channel) => {
  if (state.current) {
    window.echo.leave('channel.' + state.current.name);
  }

  commit('select', channel);
  commit('updateMessages', channel.latest_messages, { root: true });
  commit('modal/close', null, { root: true });

  window.echo
    .private('channel.' + state.current.name)
    .listen('MessageSent', ({ message }) => commit('addMessage', message, { root: true }));
};

export const add = ({ dispatch, commit }, channel) => {
  commit('add', channel);

  dispatch('select', channel);
};

export const join = ({ state, commit }, current) => {
  commit('select', current);

  commit('refresh', state.channels.map(channel => {
    if (channel.id === current.id) {
      channel.joined = true;
    }

    return channel;
  }));
};
