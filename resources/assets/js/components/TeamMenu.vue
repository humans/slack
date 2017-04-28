<template>
    <div class="team">
        <h1 class="team-name">{{ team.name }}</h1>
        <span class="logged-user">{{ currentUser.username }}</span>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  computed: mapState(['team', 'currentUser']),
}
</script>
