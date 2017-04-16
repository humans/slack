export const selectConversation = ({ commit, state }, conversation) =>  {
  if (state.conversation) {
    window.echo.leave('conversation.' + state.conversation.display_name);
  }

  commit('updateConversation', conversation);
  commit('updateMessages', conversation.latest_messages);
  commit('modal/close', null, { root: true });

  window.echo
    .private('conversation.' + conversation.display_name)
    .listen('MessageSent', ({ message }) => commit('addMessage', message, { root: true }));
};
