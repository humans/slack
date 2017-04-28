<template>
    <div class="conversation">
        <div class="onboarding">
            <div class="user">
                <img class="avatar" alt="Avatar" :src="conversation.avatar"/>

                <span class="name">{{ conversation.name }}</span>
                <span class="username">@{{ conversation.username }}</span>
            </div>

            <p class="quip">This is the very beginning of your direct message with <strong>{{ conversation.display_name }}</strong></p>
        </div>

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
    conversation: 'conversation',
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

<style>
.onboarding .user {
    display: flex;
    align-items: center;

    font-weight: 700;
}

.onboarding .name { margin-left: 1rem; }
.onboarding .username { margin-left: 0.5rem; }

.onboarding .quip {
    font-weight: 300;
    margin: 1rem 0;
    font-size: 1.25rem;
}
</style>
