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
      this.refresh();
    },

    methods: {
      ...mapMutations(['updateChannels']),
      ...mapActions(['selectChannel']),

      refresh () {
        this.$http.get('/api/channels')
          .then(({ data }) => {
            this.updateChannels(data);

            this.selectChannel(data[0]);
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
