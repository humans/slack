<template>
    <header class="client-header">
        <div class="message-details">
            <h2 class="conversation-name">
                #{{ currentChannel.name }}
            </h2>
        </div>
    </header>
</template>

<script>
import { mapState } from 'vuex';

export default {
  computed: mapState(['currentChannel']),
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
