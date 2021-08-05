<template>
    <v-container>
        <v-form @submit.prevent="register">
            <v-text-field
                v-model="form.name"
                label="Name"
                type="text"
                required
            />
            <span v-if="errors.name.length" class="red--text">{{
                errors.name[0]
            }}</span>

            <v-text-field
                v-model="form.email"
                label="Email"
                type="email"
                required
            />
            <span v-if="errors.email" class="red--text">{{
                errors.email[0]
            }}</span>

            <v-text-field
                v-model="form.password"
                label="Password"
                type="password"
                required
            />
            <span v-if="errors.password" class="red--text">{{
                errors.password[0]
            }}</span>

            <v-text-field
                v-model="form.password_confirmation"
                label="Confirm Password"
                type="password"
                required
            />

            <v-btn color="green" type="submit">Register</v-btn>

            <router-link to="/login">
                <v-btn text>Login</v-btn>
            </router-link>
        </v-form>
    </v-container>
</template>
<script>
export default {
    data() {
        return {
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            },
            errors: {}
        };
    },

    methods: {
        async register() {
            try {
                const { data } = await axios.post('api/auth/signup', this.form);

                await User.checkLoginData(data);

                this.$router.push({ name: 'forum' });
            } catch (err) {
                this.errors = err.response.data.errors;

                console.error(err);
            }
        }
    }
};
</script>
<style></style>
