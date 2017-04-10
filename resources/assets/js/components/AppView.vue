<template>
    <main class="slack">
        <sidebar></sidebar>

        <section class="workspace">
            <client-header></client-header>

            <router-view></router-view>

            <chatbox></chatbox>
        </section>

        <!-- Modal -->
        <component v-if="modal" :is="modal"></component>
    </main>
</template>

<script>
import ClientHeader from './ClientHeader.vue';
import Conversation from './Conversation.vue';
import Chatbox from './Chatbox.vue';
import CreateChannelModal from './CreateChannelModal.vue';
import ChannelBrowserModal from './ChannelBrowserModal.vue';
import Sidebar from './Sidebar.vue';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  components: {
    ClientHeader, Sidebar, Conversation, Chatbox,

    CreateChannelModal, ChannelBrowserModal,
  },

  computed: mapState({
    modal: state => state.modal.component,
    currentUser: 'currentUser',
  }),

  created () {
    this.fetchTeamDetails();
    this.fetchChannels();
    this.fetchUserDetails();
  },

  methods: {
    ...mapMutations({
      updateTeam: 'updateTeam',
      updateUserDetails: 'updateUserDetails',
      refreshChannels: 'channel/refresh',
    }),

    ...mapActions({
      selectChannel: 'channel/select'
    }),

    fetchTeamDetails () {
      this.$http.get('/api/team')
        .then(({ data }) => this.updateTeam(data));
    },

    fetchUserDetails () {
      this.$http.get('/api/me')
        .then(({ data }) => {
          this.updateUserDetails(data);

          this.redirectToTheLastChannel();
        });
    },

    fetchChannels () {
      this.$http.get('/api/channels')
        .then(({ data }) => this.refreshChannels(data));
    },

    redirectToTheLastChannel () {
      if (! this.$route.fullPath === '/') {
        return;
      }

      // Redirect the user to the last channel they were in.
      this.$router.push({
        name: 'channel',
        params: { channel: this.currentUser.settings.active_channel_id },
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
    flex-basis: calc(100% - 220px);
    width: 100%;
}

.sidebar {
    flex-basis: 220px;
    width: 220px;
}

.pull-right { margin-left: auto; }
</style>
