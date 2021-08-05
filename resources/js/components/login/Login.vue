<template>
    <v-container>
        <v-form @submit.prevent="login">
            <v-text-field
                v-model="form.email"
                label="Email"
                type="email"
                required
            />

            <v-text-field
                v-model="form.password"
                label="Password"
                type="password"
                required
            />

            <v-btn color="green" type="submit">Login</v-btn>

            <router-link to="/register">
                <v-btn text>Register</v-btn>
            </router-link>
        </v-form>
    </v-container>
</template>
<script>
export default {
    data() {
        return {
            form: {
                email: null,
                password: null
            }
        };
    },

    created() {},

    methods: {
        login() {
            User.login(this.form);
        }
    }
};
</script>
<style></style>
