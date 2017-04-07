<template>
    <aside class="sidebar">
        <channel-list></channel-list>
    </aside>
</template>

<script>
  import ChannelList from './ChannelList';

  export default {
    components: { ChannelList },
  }
</script>

<style>
  .sidebar {
      background: #2b626b;
      height: 100%;
      width: 230px;
  }
</style>

