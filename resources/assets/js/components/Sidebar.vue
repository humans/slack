<template>
    <aside class="sidebar">
        <div class="team">
            <h1 class="team-name">{{ team.name }}</h1>
        </div>

        <channel-list></channel-list>
    </aside>
</template>

<script>
import { mapState } from 'vuex';
import ChannelList from './ChannelList';

export default {
  components: { ChannelList },

  computed: mapState(['team']),
}
</script>

<style>
.sidebar {
    background: var(--sidebar-background);
    color: var(--sidebar-color);
    height: 100%;
    width: 220px;
}

.sidebar a {
    color: var(--sidebar-color);
    opacity:  0.7;
}

.sidebar-header {
    display: flex;
    padding: 0 1rem;
}

.sidebar-heading, .sidebar-heading a {
    opacity: 0.8;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    text-transform: uppercase;
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
</style>

