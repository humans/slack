<template>
    <div class="conversation">
        <message
            v-for="message in messages"
            :key="message.id"
            :message="message">
        </message>

        <div class="join-channel" v-if="! currentChannel.joined">
            <button type="button" @click="join">Join #{{ currentChannel.name }}</button>
        </div>
    </div>
</template>

<script>
import Message from './Message.vue';
import { mapState, mapActions } from 'vuex';

export default {
  components: { Message },

  computed: mapState({
    messages: 'messages',
    currentChannel: state => state.channel.current,
  }),

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
    ...mapActions({
      selectChannel: 'channel/select',
      joinChannel: 'channel/join',
    }),

    join () {
      this.$http
        .post(`/api/channels/${this.currentChannel.id}/join`)
        .then(({ data }) => this.joinChannel(data));
    },

    refresh () {
      this.$http.get(`/api/channels/${this.$route.params.channel}`)
        .then(({ data }) => {
          this.selectChannel(data)

          this.$http.patch(`/api/user/settings/conversation/channel/${data.id}`);
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
