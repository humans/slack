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

  computed: mapState(['modal', 'currentUser']),

  beforeMount () {
    this.fetchTeamDetails();
    this.fetchChannels();
    this.fetchUserDetails();
  },

  methods: {
    ...mapMutations(['updateTeam', 'updateChannels', 'updateUserDetails']),
    ...mapActions(['selectChannel']),

    fetchTeamDetails () {
      this.$http.get('/api/team')
        .then(({ data }) => this.updateTeam(data));
    },

    fetchUserDetails () {
      this.$http.get('/api/me')
        .then(({ data }) => {
          this.updateUserDetails(data);
          this.worldBuilding();
        });
    },

    fetchChannels () {
      this.$http.get('/api/channels')
        .then(({ data }) => this.updateChannels(data));
    },

    worldBuilding () {
      if (! this.$route.fullPath === '/') {
        return;
      }

      this.$router.push({
        name: 'channel',
        params: { channel: this.currentUser.settings.active_channel.id },
      });
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
    --sidebar-color: #111410;
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

.pull-right { margin-left: auto; }
</style>
