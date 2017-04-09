export const updateUserDetails = (state, user) => state.currentUser = user;

export const updateTeam = (state, team) => state.team = team;

export const openModal = (state, component) => state.modal = component;

export const closeModal = state => state.modal = null;

export const addMessage = (state, message) => state.messages.push(message);

/**
 * We have to sort them since the messages are in descending
 * order when we query it from the server.
 */
export const updateMessages = (state, messages) => {
  state.messages = messages;

  state.messages = _.orderBy(state.messages, 'created_at');
};
