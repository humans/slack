<template>
    <nav class="channel-list">
        <ul>
            <li v-for="channel in channels">
                <a href="#" @click.prevent="selectChannel(channel)">
                    {{ channel.name }}
                </a>
            </li>

            <li><a href="#" @click="create = true">Create a new channel.</a></li>
        </ul>

        <create-channel v-if="create" @submit="createChannel"></create-channel>
    </nav>
</template>

<script>
  import CreateChannel from './CreateChannel.vue';
  import { mapState, mapMutations, mapActions } from 'vuex';

  export default {
    components: { CreateChannel },

    computed: mapState(['channels']),

    data () {
      return { create: false };
    },

    mounted () {
      this.subscribe();
    },

    methods: {
      ...mapMutations(['addChannel']),
      ...mapActions({
        selectChannel: 'selectChannel',
        addAndJoinChannel: 'addChannel',
      }),

      subscribe () {
        this.$echo
          .private('channel')
          .listen('ChannelCreated', (e) => this.addChannel(e.channel));
      },

      createChannel (data) {
        this.create = false;

        this.$http.post(`/api/channels`, data)
          .then(({ data }) => this.addAndJoinChannel(data));
      },
    },
  }
</script>
