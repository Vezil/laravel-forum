<template>
    <v-card class="mt-2" color="#e0e6fb">
        <v-card-title primary-title>
            <div>
                <router-link :to="question.path">
                    <h2 class="headline mb-0 title">{{ question.title }}</h2>
                </router-link>

                <div class="grey--text">
                    {{ question.user }}
                    <small>asked {{ question.created_at }}</small>
                </div>
            </div>
        </v-card-title>
        <v-card-text>
            {{ question.body }}
        </v-card-text>
    </v-card>
</template>
<script>
export default {
    props: {
        question: {
            type: Object,
            required: true,
            default: () => ({})
        }
    }
};
</script>
<style>
.title {
    color: black;
}
a {
    text-decoration: none;
}
</style>
