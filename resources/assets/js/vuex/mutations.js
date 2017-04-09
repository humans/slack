import _ from 'lodash';

export const updateUserDetails = (state, user) => state.currentUser = user;

export const updateTeam = (state, team) => state.team = team;

export const openModal = (state, component) => state.modal = component;

export const closeModal = state => state.modal = null;

export const addMessage = (state, message) => state.messages.push(message);

/*
|--------------------------------------------------------------------------
| Channel
|--------------------------------------------------------------------------
|
| Here are all the channel related mutations, the best bet here is to
| refactor them into it's own module since it's starting to get a bit
| bigger.
|
*/

/**
 * We have to sort them since the messages are in descending
 * order when we query it from the server.
 */
export const updateMessages = (state, messages) => {
  state.messages = messages;

  state.messages = _.orderBy(state.messages, 'created_at');
};

export const updateChannels = (state, channels) => state.channels = channels;

export const selectChannel = (state, channel) => state.currentChannel = channel;

export const addChannel = (state, channel) => {
  state.channels.push(channel);

  state.channels = _.orderBy(state.channels, 'name');
};
