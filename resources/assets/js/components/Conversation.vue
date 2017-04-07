<template>
    <div class="conversation">
        <ul>
            <li v-for="message in messages">
                <strong>{{ message.user.username }}</strong>: {{ message.content }}
            </li>
        </ul>
    </div>
</template>

<script>
  import { mapState, mapMutations } from 'vuex';

  export default {
    computed: mapState(['messages', 'currentChannel']),

    data () {
      return { team: window.Slack.team };
    },

    mounted () {
      this.fetchChannelMessage();
    },

    watch: {
      '$route' (route) {
        this.fetchChannelMessages();
      },
    },

    methods: {
      ...mapMutations(['selectChannel', 'addMessage', 'updateMessages']),

      refresh () {
        this.$http.get(`/api/channels/${this.$route.params.channel}`)
          .then(({ data }) => {
            this.selectChannel(data);

            this.updateMessages(data.latest_messages);

            this.subscribe();
          });
      },

      fetchChannelMessages () {
        if (this.currentChannel) {
          this.$echo.leave(this.currentChannel.name);
        }

        this.$http.get(`/api/channels/${this.currentChannel.id}`)
          .then(({ data }) => this.updateMessages(data.latest_messages));

        this.subscribe();
      },

      subscribe () {
        console.error('subscribing');
        console.error(`${this.team}.channel.${this.currentChannel.name}`);
        this.$echo
          .private(`${this.team}.channel.${this.currentChannel.name}`)
          .listen('MessageSent', ({ message }) => this.addMessage(message));
      },
    },
  };
</script>
