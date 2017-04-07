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
        
            this.subscribe();
          });
      },

      fetchChannelMessages () {
        this.$http.get(`/api/channels/${this.currentChannel.id}`)
          .then(({ data }) => this.updateMessages(data.latest_messages));
        
        this.subscribe();
      },

      subscribe () {
        this.$echo
          .private('channel.' + this.currentChannel.name)
          .listen('MessageSent', ({ message }) => this.addMessage(message));
      },
    },
  };
</script>
