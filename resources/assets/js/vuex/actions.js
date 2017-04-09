export const selectChannel = ({ commit, state }, channel) => {
  if (state.currentChannel) {
    window.echo.leave('channel.' + state.currentChannel.name);
  }

  commit('selectChannel', channel);
  commit('updateMessages', channel.latest_messages);
  commit('closeModal');

  window.echo
    .private('channel.' + state.currentChannel.name)
    .listen('MessageSent', ({ message }) => commit('addMessage', message));
};

export const addChannel = ({ dispatch, commit }, channel) => {
  commit('addChannel', channel);

  dispatch('selectChannel', channel);
};
