<template>
    <main class="slack">
        <sidebar></sidebar>

        <section class="workspace">
            <router-view></router-view>

            <chatbox></chatbox>
        </section>

        <!-- Modal -->
        <component v-if="modal" :is="modal"></component>
    </main>
</template>

<script>
  import Conversation from './Conversation.vue';
  import Chatbox from './Chatbox.vue';
  import CreateChannelModal from './CreateChannelModal.vue';
  import Sidebar from './Sidebar.vue';
  import { mapState, mapActions, mapMutations } from 'vuex';

  export default {
    components: { Sidebar, Conversation, Chatbox, CreateChannelModal },

    computed: mapState(['modal', 'userSettings']),

    mounted () {
      this.fetchUserSettings();
      this.fetchChannels();
    },

    methods: {
      ...mapMutations(['updateChannels', 'updateUserSettings']),
      ...mapActions(['selectChannel']),

      fetchUserSettings () {
        this.$http.get('/api/user/settings')
          .then(({ data }) => {
            this.updateUserSettings(data);

            this.worldBuilding();
          });
      },

      worldBuilding () {
        if (! this.$route.fullPath === '/') {
          return;
        }

        this.$router.push({
          name: 'channel',
          params: { channel: this.userSettings.active_channel.id },
        });
      },

      fetchChannels () {
        this.$http.get('/api/channels')
          .then(({ data }) => this.updateChannels(data));
      },
    },
  };
</script>

<style>
.slack {
    height: 100%;
    width: 100%;
    display: flex;
}

.conversation {
    height: 80%;
}

.workspace {
    display: flex;
    flex-direction: column;
}
</style>
