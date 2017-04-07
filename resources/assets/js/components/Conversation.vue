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
      this.refresh();
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
        try {
          // this.$echo
            // .private(`${this.team}.channel.${this.currentChannel.name}`)
            // .listen('MessageSent', ({ message }) => this.addMessage(message));
        } catch (error) {
          // This does a weird login which everything still works,
          // I just don't want any errors to be thrown.
        }
      },
    },
  };
</script>
