<template>
    <main class="slack">
        <sidebar></sidebar>

        <section class="workspace">
            <conversation></conversation>

            <chatbox></chatbox>
        </section>
    </main>
</template>

<script>
  import { mapActions, mapMutations } from 'vuex';

  export default {
    mounted () {
      this.fetchChannels();
    },

    methods: {
      ...mapMutations(['updateChannels']),
      ...mapActions(['selectChannel']),

      fetchChannels () {
        this.$http.get('/api/channels')
          .then(({ data }) => {
            this.updateChannels(data);
          });
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
