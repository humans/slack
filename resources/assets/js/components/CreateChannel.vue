<template>
    <div class="create-channel modal">
        <form method="POST" @submit.prevent="submit">
            <div class="field">
                <label for="name">Channel Name</label>
                <input id="name" name="name" type="text" v-model="name">
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea cols="30" id="description" name="" rows="10" v-model="description"></textarea>
            </div>

            <button type="submit">Create</button>
        </form>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        name: null,
        description: null,
      };
    },

    methods: {
      submit () {
        this.$emit('submit', this.$data);
      },
    },
  }
</script>
