<template>
    <nav class="user-list">
        <header class="sidebar-header">
            <h3 class="sidebar-heading">
                <a href="#">Direct Messages</a>
            </h3>

            <a href="#" class="plus pull-right">
                +
            </a>
        </header>

        <ul class="sidebar-items">
            <li class="sidebar-item" v-for="user in users">
                <router-link
                    active-class="active"
                    class="sidebar-item-link"
                    :to="{ 
                         name: 'user', 
                         params: { user: user.username },
                    }">
                    {{ user.username }}
                </router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
import { mapState } from 'vuex';

export default {
  computed: mapState(['users'])
}
</script>
