<template>
    <div class="create-channel modal">
        <form method="POST" @submit.prevent="submit">
            <div class="field" :class="{ 'has-error': hasErrors('name') }">
                <label for="name">Channel Name</label>
                <input id="name" name="name" type="text" v-model="name" autofill="off">

                <p class="field-error" v-if="hasErrors('name')">
                    {{ error('name') }}
                </p>
            </div>

            <div class="field" :class="{ '-error': hasErrors('description') }">
                <label for="description">Description</label>
                <textarea cols="30" id="description" name="" rows="10" v-model="description"></textarea>

                <p class="field-error" v-if="hasErrors('description')">
                    {{ error('description') }}
                </p>
            </div>

            <button type="submit">Create</button>
        </form>
    </div>
</template>

<script>
  export default {
    props: ['errors'],

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

      hasErrors (field) {
        return this.errors.hasOwnProperty(field);
      },

      error (field) {
        return this.errors[field][0];
      },
    },
  }
</script>
