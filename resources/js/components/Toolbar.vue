<template>
    <v-toolbar>
        <v-toolbar-title>
            <router-link to="/">Laravel-Forum</router-link>
        </v-toolbar-title>
        <v-spacer />

        <app-notification v-if="isLogged" />

        <div class="hidden-sm-and-down">
            <router-link
                v-for="item in menuItems"
                v-show="item.show"
                :key="item.title"
                :to="item.to"
            >
                <v-btn text>{{ item.title }}</v-btn>
            </router-link>
        </div>
    </v-toolbar>
</template>
<script>
import AppNotification from './AppNotification';

export default {
    components: { AppNotification },

    data() {
        return {
            isLogged: User.isLogged(),
            menuItems: [
                { title: 'Forum', to: '/forum', show: true },
                { title: 'Ask Question', to: '/ask', show: User.isLogged() },
                { title: 'Category', to: '/category', show: User.isAdmin() },
                { title: 'Login', to: '/login', show: !User.isLogged() },
                { title: 'Logout', to: '/logout', show: User.isLogged() }
            ]
        };
    },

    created() {
        EventBus.$on('logout', () => {
            User.logout();
        });
    }
};
</script>
<style>
.v-toolbar__content {
    background-color: #b3d4fc;
    box-shadow: 8px 8px 12px 14px rgba(0, 0, 0, 0.04);
}
</style>
