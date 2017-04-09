<template>
    <aside class="sidebar">
        <team-menu></team-menu>

        <channel-list></channel-list>
    </aside>
</template>

<script>
import ChannelList from './ChannelList.vue';
import TeamMenu from './TeamMenu.vue';

export default {
  components: { ChannelList, TeamMenu },
}
</script>

<style>
.sidebar {
    background: var(--sidebar-background);
    color: var(--sidebar-color);
    height: 100%;
}

.sidebar a {
    color: var(--sidebar-color);
    opacity:  0.7;
}

.sidebar-header {
    display: flex;
    padding: 0 1rem;
    align-items: center;
    height: 2rem;
}

.sidebar-heading {
    opacity: 0.8;
    font-size: 13px;
    font-weight: 700;
    line-height: 1;
    text-transform: uppercase;
}

.sidebar-heading .pull {
    line-height: 1;
}

.sidebar-heading a {
    text-decoration: none;
}

.sidebar-heading a:hover {
    opacity: 1;
}

.team {
    padding: 1rem;
}

.team-name {
    font-size: 1.125rem;
    font-weight: 700;
}

.plus {
    text-decoration: none;
}
</style>

