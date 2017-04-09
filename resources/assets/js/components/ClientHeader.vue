<template>
    <header class="client-header">
        <div class="message-details">
            <h2 class="conversation-name">
                #{{ channel.name }}
            </h2>
        </div>
    </header>
</template>

<script>
import { mapState } from 'vuex';

export default {
  computed: mapState({
    channel: state => state.channel.current
  }),
}
</script>

<style>
.client-header {
    border-bottom: 1px solid #e8e8e8;
    padding: 1.25rem;
}

.conversation-name {
    font-size: 1rem;
    margin: 0;
}
</style>
