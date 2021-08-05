import Vue from 'vue';
import VueRouter from 'vue-router';
import HomePage from '../components/HomePage';
import Login from '../components/login/Login';
import Register from '../components/login/Register';
import Forum from '../components/forum/Forum';
import Logout from '../components/login/Logout';
import Read from '../components/forum/Read';
import CreateQuestion from '../components/forum/CreateQuestion';
import CreateCategory from '../components/category/CreateCategory';
import VerifyAccount from '../components/account/VerifyAccount';

Vue.use(VueRouter);

function verifyUnlogged(to, from, next) {
    if (User.isLogged()) {
        this.$router.push({ name: 'forum' });
    } else return next();
}

function verifyAdmin(to, from, next) {
    if (User.isAdmin()) {
        next();
    } else return next('/forum');
}

const routes = [
    {
        path: '/',
        component: HomePage
    },
    {
        path: '/login',
        component: Login,
        beforeEnter: (to, from, next) => verifyUnlogged(to, from, next)
    },
    { path: '/logout', component: Logout },
    {
        path: '/register',
        component: Register,
        beforeEnter: (to, from, next) => verifyUnlogged(to, from, next)
    },
    { path: '/forum', component: Forum, name: 'forum' },
    {
        path: '/category',
        component: CreateCategory,
        beforeEnter: (to, from, next) => verifyAdmin(to, from, next)
    },
    { path: '/ask', component: CreateQuestion },
    { path: '/question/:slug', component: Read, name: 'read' },
    { path: '/account/verify', component: VerifyAccount, name: 'verifyAccount' }
];

const router = new VueRouter({
    routes,
    mode: 'history'
});

export default router;
