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
:root {
    --black: #2c2d30;
    --grey: #9e9ea7;
    --flesh: #f3e3cc;
    --orange: #f3951d;
    --sidebar-background: var(--flesh);
    --sidebar-color-root: #828d71;
    --sidebar-color-accent: #101410;
    --sidebar-highlight: var(--orange);
}

* {
    margin: 0;
    padding: 0;
}

*, *:before, *:after {
    box-sizing: border-box;
}

html, body {
    color: var(--black);
    font-family: 'Lato', sans-serif;
    font-size: 16px;
}

html, body, #app {
    height: 100%;
    width: 100%;
    line-height: 1.2;
}

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
