<template>
    <nav class="channel-list">
        <header>
            <h3>Channels</h3>

            <a href="#" @click.prevent="openModal('create-channel-modal')">
                Create a new channel.
            </a>
        </header>

        <ul>
            <li v-for="channel in channels">
                <router-link
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
  import { mapState, mapMutations, mapActions } from 'vuex';

  export default {
    computed: mapState(['channels']),

    mounted () {
      this.subscribe();
    },

    methods: {
      ...mapMutations(['addChannel', 'openModal']),
      ...mapActions(['selectChannel']),

      subscribe () {
        this.$echo
          .private('channel')
          .listen('ChannelCreated', (e) => this.addChannel(e.channel));
      },
    },
  }
</script>
