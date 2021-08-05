<template>
    <div>
        <toolbar></toolbar>
        <router-view></router-view>
        <app-footer v-if="$route.fullPath !== '/'"></app-footer>
    </div>
</template>

<script>
import Toolbar from './Toolbar';
import AppFooter from './AppFooter';
import Login from './login/Login';

export default {
    components: {
        Toolbar,
        AppFooter,
        Login
    }
};
</script>
<style></style>
