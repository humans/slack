export const joinedChannels = state => state.channels.filter(channel => channel.joined);
export const availableChannels = state => state.channels.filter(channel => ! channel.joined);
export const totalChannels = state => state.channels.length;
