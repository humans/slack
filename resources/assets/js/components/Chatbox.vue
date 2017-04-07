<template>
    <div class="chatbox">
        <input name="message" type="text" v-model="message" @keyup.enter="send">
    </div>
</template>

<script>
  import { mapState, mapMutations } from 'vuex';

  export default {
    computed: mapState(['currentChannel']),

    data () {
      return { message: null };
    },

    methods: {
      ...mapMutations(['addMessage']),

      send () {
        this.$http
          .post(`/api/channels/${this.currentChannel.id}/messages`, { message: this.message })
          .then(({ data }) => this.addMessage(data));

        this.message = null;
      },
    },
  };
</script>
