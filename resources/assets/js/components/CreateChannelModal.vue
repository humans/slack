<template>
    <modal class="create-channel">
        <template slot="heading">Create a channel</template>
        <template slot="note">Channels are where your team communicates. They’re best when organized around a topic — #leads, for example.</template>

        <form @submit.prevent="submit">
            <field name="name" label="Channel Name"
                :errors="errors.name" v-model="name">
            </field>

            <field name="description" label="Purpose" optional
                :errors="errors.description" v-model="description">
            </field>

            <button type="submit">Create</button>
        </form>
    </modal>
</template>

<script>
import { mapMutations } from 'vuex';
import Modal from './Modal';

export default {
  components: { Modal },

  data () {
    return {
      name: null,
      description: null,
      errors: {},
    };
  },

  methods: {
    ...mapMutations({
      addChannel: 'channel/add'
    }),

    submit () {
      this.$http.post('/api/channels', this.$data)
        .then(({ data }) => {
          data.joined = true;

          this.addChannel(data);

          this.$router.push({
            name: 'channel',
            params: { channel: data.id },
          });
        })
        .catch((error) => {
          this.errors = error.response.data;
        });
    },
  },
};
</script>
