<template>
    <footer class="chatbox">
        <div class="chatbox-field">
            <input class="chatbox-input" name="message" type="text"
                   :placeholder="placeholder"
                   v-model="message" @keyup.enter="send">
        </div>
    </footer>
</template>

<script>
import { mapState, mapMutations } from 'vuex';

export default {
  computed: {
    ...mapState({
      channel: state => state.channel.current 
    }),

    placeholder () {
      if (! this.channel) {
        return null;
      }

      return `Message #${this.channel.name}`;
    },
  },

  data () {
    return { message: null };
  },

  methods: {
    ...mapMutations(['addMessage']),

    send () {
      this.$http
        .post(`/api/channels/${this.channel.id}/messages`, { message: this.message })
        .then(({ data }) => this.addMessage(data));

      this.message = null;
    },
  },
};
</script>

<style>
.chatbox {
    height: 4rem;
    padding: 0 1.25rem;
}

.chatbox-field {
    border-radius: 7px;
    border: 2px solid #bbbdbf;
    height: 2.75rem;
}

.chatbox-input {
    height: 100%;
    width: 100%;

    background-color: transparent;
    border: none;
    font-size: 1rem;
    font-family: 'Lato', sans-serif;
    padding: 0.5rem;
    outline: none;
}

.chatbox-input::-webkit-input-placeholder {
    color: #a0a0a0;
    font-weight: 300;
}

.chatbox-input:focus::-webkit-input-placeholder {
    color: #a0a0a0;
    font-weight: 300;
}

.chatbox-input:-moz-placeholder {
    color: #a0a0a0;
    font-weight: 300;
}

.chatbox-input::-moz-placeholder {
    color: #a0a0a0;
    font-weight: 300;
}

.chatbox-input:-ms-input-placeholder {
    color: #a0a0a0;
    font-weight: 300;
}

</style>
