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

        <div v-if="errorMessage" class="red--text mt-4">
            {{ errorMessage }}
        </div>
    </v-container>
</template>
<script>
export default {
    data() {
        return {
            form: {
                email: null,
                password: null
            },
            errorMessage: ''
        };
    },

    methods: {
        async login() {
            const { isError, errorStatus } = await User.login(this.form);

            if (isError) {
                this.errorMessage =
                    errorStatus === 401
                        ? 'Email or password incorrect! Try again'
                        : 'Something was wrong. Try again later';
            }
        }
    }
};
</script>
<style></style>
