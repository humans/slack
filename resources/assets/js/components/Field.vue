<template>
    <div class="field" :class="{ 'has-error': hasErrors }">
        <label class="field-label" :for="name">
            {{ label }}
            <small v-if="optional" class="field-optional">
                (optional)
            </small>
        </label>

        <input :id="name" :name="name" :type="type"
               class="field-input" autofill="off"
               :value="value"
               @input="$emit('input', $event.target.value)">

        <p class="field-error" v-if="hasErrors">
            {{ error }}
        </p>
    </div>
</template>

<script>
export default {
  props: {
    label: String,
    name: String,
    errors: Object,
    optional: {
      type: Boolean,
      default: false,
    },
    type: {
      type: String,
      default: 'text',
    }
  },

  data () {
    return { value: null };
  },

  computed: {
    error () {
      return this.errors[this.name][0];
    },

    hasErrors () {
      return typeof this.errors !== 'undefined';
    },
  },
}
</script>

<style>
</style>
