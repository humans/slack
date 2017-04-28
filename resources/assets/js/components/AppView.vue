<template>
    <main class="slack">
        <sidebar></sidebar>

        <section class="workspace">
            <client-header></client-header>

            <router-view></router-view>

            <chatbox></chatbox>
        </section>

        <!-- Modal -->
        <transition name="slide-from-bottom">
            <component v-if="modal" :is="modal"></component>
        </transition>
    </main>
</template>

<script>
import ClientHeader from './ClientHeader.vue';
import Chatbox from './Chatbox.vue';
import CreateChannelModal from './CreateChannelModal.vue';
import ChannelBrowserModal from './ChannelBrowserModal.vue';
import Sidebar from './Sidebar.vue';
import { mapState, mapActions, mapMutations } from 'vuex';

export default {
  components: {
    ClientHeader, Sidebar, Chatbox,

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
    this.fetchUsers();
  },

  methods: {
    ...mapMutations({
      updateTeam: 'updateTeam',
      updateUserDetails: 'updateUserDetails',
      refreshChannels: 'channel/refresh',
      refreshUsers: 'refreshUsers',
    }),

    fetchUsers () {
      this.$http.get('/api/users')
        .then(({ data }) => this.refreshUsers(data));
    },

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
      let params = {};

      if (! this.$route.fullPath === '/') {
        return;
      }

      if (this.currentUser.settings.active_conversation_type === 'channel') {
        params.channel = this.currentUser.settings.conversation.id;
      } else {
        params.user = this.currentUser.settings.conversation.username;
      }

      // Redirect the user to the last channel they were in.
      this.$router.push({
        name: this.currentUser.settings.active_conversation_type,
        params: params,
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

.u-td-n { text-decoration: none; }
.u-fs-i { font-style: italic; }
.u-fw-100 { font-weight: 100; }
.u-fw-300 { font-weight: 300; }
.u-fw-400 { font-weight: 400; }
.u-fw-700 { font-weight: 700; }
.pull-right { margin-left: auto; }

.slide-from-bottom-enter-active, .slide-from-bottom-leave-active {
    transition: transform 0.25s, opacity .25s ease-in-out;
}

.slide-from-bottom-enter, .slide-from-bottom-leave-to {
    opacity: 0;
    transform: translateY(1rem);
}

</style>
