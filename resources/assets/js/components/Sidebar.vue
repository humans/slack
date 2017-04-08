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
    background: var(--sidebar-background);
    color: var(--sidebar-color-root);
    height: 100%;
    width: 220px;
}

.sidebar a {
    color: var(--sidebar-color-root);
}
</style>

