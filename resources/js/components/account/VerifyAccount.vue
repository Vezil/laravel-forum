<template>
    <div class="text-center">
        <v-dialog
            v-if="code"
            v-model="dialog"
            max-width="600"
            height="300"
            transition="dialog-bottom-transition"
        >
            <v-card class="px-auto py-auto blue lighten-5 text-center">
                <v-card-title class="blue lighten-1">
                    Account Verification
                </v-card-title>

                <v-card-text class="vuetify-card">
                    <span v-if="loading">
                        Please wait verification is in process ...
                    </span>
                    <span
                        v-else-if="alreadyVerified"
                        class="green--text text--darken-3"
                    >
                        Your account is already verified!<br />
                        You will be redirected to the forum soon...
                    </span>
                    <span
                        v-else-if="verificationSuccess"
                        class="green--text text--darken-3"
                    >
                        Account successfully verified! :)<br />
                        You will be redirected to the forum soon...
                    </span>
                    <span v-else class="red--text text--darken-3">
                        Sorry! something went wrong during<br />
                        verification account :( <br />
                        You will be redirected to the forum soon...
                    </span>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    data() {
        return {
            dialog: true,
            loading: true,
            verificationSuccess: false,
            alreadyVerified: false,
            code: ''
        };
    },
    mounted() {
        const { code } = this.$route.query;

        this.code = code;

        if (!this.code) {
            this.$router.push({ name: 'forum' });

            return;
        }

        this.verifyAccount(this.code);
    },
    methods: {
        async verifyAccount(code) {
            try {
                const { data } = await axios.post('/api/auth/verify', { code });

                this.verificationSuccess = data.verified;
                this.alreadyVerified = data.alreadyVerified;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;

                setTimeout(() => {
                    this.$router.push({ name: 'forum' });
                }, 6000);
            }
        }
    }
};
</script>
<style scoped>
.vuetify-card {
    padding: 150px 50px !important;
}

.vuetify-card span {
    font-size: 1.2rem;
    line-height: 1.6;
}
</style>
