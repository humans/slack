<template>
    <aside class="sidebar">
        <team-menu></team-menu>

        <channel-list></channel-list>

        <direct-messages></direct-messages>
    </aside>
</template>

<script>
import ChannelList from './ChannelList.vue';
import DirectMessages from './DirectMessages.vue';
import TeamMenu from './TeamMenu.vue';

export default {
  components: { ChannelList, DirectMessages, TeamMenu },
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

.sidebar-items {
    list-style: none;
}

.sidebar-item-link {
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;

    display: block;
    line-height: 1.4;
    margin-right: 1rem;
    padding-left: 1.5rem;
    text-decoration: none;
}

.sidebar-item-link.active {
    background-color: var(--sidebar-highlight);
    opacity: 1;
}

.sidebar-item-link:hover:not(.active) {
    background-color: #f3956a;
}
</style>

