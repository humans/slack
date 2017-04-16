<template>
    <div class="conversation">
        <message
            v-for="message in messages"
            :key="message.id"
            :message="message">
        </message>

        <div class="join-channel" v-if="! conversation.joined">
            <button type="button" @click="join">Join #{{ conversation.name }}</button>
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
    conversation: state => state.conversation,
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
      joinChannel: 'channel/join',
      selectConversation: 'selectConversation',
    }),

    join () {
      this.$http
        .post(`/api/channels/${this.conversation.id}/join`)
        .then(({ data }) => this.joinChannel(data));
    },

    refresh () {
      this.$http.get(`/api/channels/${this.$route.params.channel}`)
        .then(({ data }) => {
          this.selectConversation(data);

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
