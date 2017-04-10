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

        <ul class="channels">
            <li class="channel" v-for="channel in channels">
                <router-link
                    active-class="active"
                    class="channel-link"
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
.channels {
    list-style: none;
}

.channel-link {
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;

    display: block;
    line-height: 1.4;
    margin-right: 1rem;
    padding-left: 1.5rem;
    text-decoration: none;
}

.channel-link:before {
    content: '#';
    opacity: 0.35;
}

.channel-link.active {
    background-color: var(--sidebar-highlight);
    opacity: 1;
}

.channel-link:hover:not(.active) {
    background-color: #f3956a;
}
</style>
