<template>
  <ul>
      <li v-for="channel in channels">
          <a href="#" @click.prevent="selectChannel(channel)">
              {{ channel.name }}
          </a>
      </li>
  </ul>
</template>

<script>
  import { mapState, mapActions } from 'vuex';

  export default {
    computed: mapState(['channels']),
    methods: mapActions(['selectChannel']),
  }
</script>
