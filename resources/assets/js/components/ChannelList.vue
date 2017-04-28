<template>
    <nav class="channel-list">
        <header class="sidebar-header">
            <h3 class="sidebar-heading">
                <a href="#" @click.prevent="openModal('channel-browser-modal')">Channels ({{ total }})</a>
            </h3>

            <a href="#" class="plus pull-right" @click.prevent="openModal('create-channel-modal')">
                +
            </a>
        </header>

        <ul class="sidebar-items">
            <li class="sidebar-item" v-for="channel in channels">
                <router-link
                    active-class="active"
                    class="sidebar-item-link channel-link"
                    :to="{ 
                         name: 'channel', 
                         params: { channel: channel.id },
                    }">
                    {{ channel.name }}
                </router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from 'vuex';

export default {
  computed: mapGetters({
    channels: 'channel/joined',
    total: 'channel/total',
  }),

  mounted () {
    this.subscribe();
  },

  methods: {
    ...mapActions(['channel/select']),
    ...mapMutations({
      addChannel: 'channel/add',
      openModal: 'modal/open',
    }),

    subscribe () {
      this.$echo
        .private('channel')
        .listen('ChannelCreated', (e) => this.addChannel(e.channel));
    },
  },
};
</script>

<style>
.channel-link:before {
    content: '#';
    opacity: 0.35;
}
</style>
