export const joined    = state => state.channels.filter(channel => channel.joined);
export const available = state => state.channels.filter(channel => ! channel.joined);
export const total     = state => state.channels.length;
