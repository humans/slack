<template>
  <modal class="channel-browser">
      <template slot="heading">Browse all {{ total }} channels</template>

      <div class="list-items">
          <div class="channel-browser-divider">Channels you can join</div>
          <div class="channel" v-for="channel in availableChannels">
              #{{ channel.name }}
          </div>

          <div class="channel-browser-divider">Channels you belong to</div>
          <div class="channel" v-for="channel in joinedChannels">
              #{{ channel.name }}
          </div>
      </div>
  </modal>
</template>

<script>
import { mapGetters } from 'vuex';
import Modal from './Modal.vue';

export default {
  components: { Modal },

  computed: mapGetters({
    availableChannels: 'channel/available',
    joinedChannels: 'channel/joined',
    total: 'channel/total',
  }),
}
</script>
