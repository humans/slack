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

  computed: mapState({
    messages: 'messages',
  }),

  mounted () {
    this.refresh();
  },

  watch: {
    '$route' (route) {
      this.refresh();
    },
  },

  methods: {
    ...mapMutations(['updateMessages']),
    ...mapActions(['selectConversation']),

    refresh () {
      this.$http.get(`/api/conversations/${this.$route.params.user}`)
        .then(({ data }) => {
          this.selectConversation(data);

          this.$http.patch(`/api/user/settings/conversation/user/${this.$route.params.user}`);
        });
    },
  },
}
</script>
