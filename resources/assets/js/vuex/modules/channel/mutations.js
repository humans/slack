import _ from 'lodash';

export const refresh = (state, channels) => state.channels = channels;

export const select = (state, channel) => state.current = channel;

export const add = (state, channel) => {
  state.channels.push(channel);

  state.channels = _.orderBy(state.channels, 'name');
};
