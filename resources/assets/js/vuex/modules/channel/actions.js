export const join = ({ state, commit }, current) => {
  commit('select', current);

  commit('refresh', state.channels.map(channel => {
    if (channel.id === current.id) {
      channel.joined = true;
    }

    return channel;
  }));
};
