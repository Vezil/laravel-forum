<template>
    <v-parallax
        dark
        src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
        height="950"
    >
        <v-row align="center" justify="center">
            <v-col class="text-center" cols="12">
                <h1 class="display-4 font-weight-thin mb-4">
                    <b>Laravel - Real Time Forum</b>
                </h1>
                <h4 class="subheading display-1">
                    <router-link
                        :to="isLogged ? '/forum' : '/login'"
                        class="blue--text text--lighten-4"
                    >
                        {{
                            isLogged
                                ? 'Ask a question!'
                                : 'Log in and ask a question!'
                        }}
                    </router-link>
                </h4>
            </v-col>
        </v-row>
    </v-parallax>
</template>

<script>
export default {
    data() {
        return {
            isLogged: User.isLogged()
        };
    }
};
</script>
