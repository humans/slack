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
      this.fetchChannelMessages();
    },

    watch: {
      '$route' (route) {
        this.fetchChannelMessages();
      },
    },

    methods: {
      ...mapMutations(['selectChannel', 'addMessage', 'updateMessages']),

      fetchChannelMessages () {
        if (this.currentChannel) {
          console.error('Disconnecting from ' + this.team + '.channel.' + this.currentChannel.name);
          this.$echo.leave(this.team + '.channel.' + this.currentChannel.name);
        }

        this.$http.get(`/api/channels/${this.$route.params.channel}`)
          .then(({ data }) => {
            this.selectChannel(data);

            this.updateMessages(data.latest_messages);

            this.subscribe();
          });
        
      },

      subscribe () {
        console.error('Connecting to ' + this.team + '.channel.' + this.currentChannel.name);
        this.$echo
          .private('artisanph.channel.general')
          .listen('MessageSent', ({ message }) => this.addMessage(message));
      },
    },
  };
</script>
