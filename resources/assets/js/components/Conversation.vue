<template>
    <div class="conversation">
        <message
            v-for="message in messages"
            :key="message.id"
            :message="message">
        </message>
    </div>
</template>

<script>
  import Message from './Message.vue';
  import { mapState, mapMutations, mapActions } from 'vuex';

  export default {
    components: { Message },

    computed: mapState(['messages']),

    data () {
      return { team: window.Slack.team };
    },

    mounted () {
      this.refresh();
    },

    watch: {
      '$route' (route) {
        this.refresh();
      },
    },

    methods: {
      ...mapMutations(['addMessage', 'updateMessages']),
      ...mapActions({
        selectChannel: 'channel/select',
      }),

      refresh () {
        this.$http.get(`/api/channels/${this.$route.params.channel}`)
          .then(({ data }) => {
            this.selectChannel(data)

            this.$http.patch(`/api/user/settings/active_channel/${data.id}`);
          });
      },
    },
  };
</script>

<style>
.conversation {
    font-size: 15px;
    height: calc(100% - 4rem);
    overflow: auto;
    padding: 1.25rem;
}
</style>
