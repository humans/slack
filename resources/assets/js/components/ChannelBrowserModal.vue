<template>
    <modal class="channel-browser">
      <template slot="heading">Browse all {{ total }} channels</template>

      <div class="list-items">
          <div class="list-item-divider" v-if="availableChannels.length">Channels you can join</div>
          <div class="list-item" v-for="channel in availableChannels" @click="select(channel)">
              <router-link :to="{
                name: 'channel',
                params: { channel: channel.id }}">
                  #{{ channel.name }}
              </router-link>
          </div>

          <div class="list-item-divider">Channels you belong to</div>
          <div class="list-item" v-for="channel in joinedChannels" @click="select(channel)">
              <router-link class="u-td-n" :to="{
                    name: 'channel',
                    params: { channel: channel.id }
                  }">
                <div class="details">
                  <span class="u-fw-100">#</span>
                  <strong class="u-fw-700">{{ channel.name }}</strong>
                  <small class="channel-joined [ u-fw-300 ]">JOINED</small>

                  <p class="list-item-description [ u-fs-i u-fw-100 ]">
                    Created by <span class="creator">jaggy</span> on <span class="date">{{ $moment(channel.created_at).format('MMM Do, YYYY') }}</span>
                  </p>
                </div>
                <div class="users-count pull-right">
                  {{ channel.users_count }}
                </div>
              </router-link>
          </div>
      </div>
    </modal>
</template>

<script>
import { mapMutations, mapGetters } from 'vuex';
import Modal from './Modal.vue';

export default {
  components: { Modal },

  computed: mapGetters({
    availableChannels: 'channel/available',
    joinedChannels: 'channel/joined',
    total: 'channel/total',
  }),

  methods: {
    ...mapMutations({
      'closeModal': 'modal/close',
    }),

    select (channel) {
      this.$router.push({
        name: 'channel',
        params: { channel: channel.id }
      });

      this.closeModal();
    },
  },
};
</script>

<style>
.list-items {
    margin-top: 2rem;
}

.list-item-divider {
    font-size: 0.875rem;
    font-weight: 700;
    border-bottom: 1px solid #e8e8e8;
    padding: 0.75rem 0.75rem;
}

.list-item {
    border: 1px solid transparent;
    border-bottom: 1px solid #e8e8e8;
    padding: 0.75rem 0.5rem;
}

.list-item:hover {
    background-color: #edf7fd;
    border: 1px solid #d3ecfa;
    border-radius: 3px;
    cursor: pointer;
}

.list-item:hover .users-count {
    display: none;
}

.list-item a {
    color: #555459;

    display: flex;
    align-items: center;
}

.list-item-description {
    color: #727375;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.channel-joined {
    font-size: 0.675rem;
    margin-left: 0.5rem;
}

.creator {
    color: #2c2d30;
}
</style>
