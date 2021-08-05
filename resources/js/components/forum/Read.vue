<template>
    <div v-if="question">
        <edit-question v-if="editing" :question="question" />
        <show-question v-else :question="question" />

        <v-container>
            <replies :question="question" />
            <new-reply v-if="loggedIn" :questionSlug="question.slug" />
            <div v-else class="mt-4 text-center">
                <router-link to="/login">Login to reply </router-link>
            </div>
        </v-container>
    </div>
</template>
<script>
import ShowQuestion from './ShowQuestion';
import EditQuestion from './EditQuestion';
import Replies from '../reply/Replies';
import NewReply from '../reply/NewReply';

export default {
    components: {
        ShowQuestion,
        EditQuestion,
        Replies,
        NewReply
    },

    computed: {
        loggedIn() {
            return User.isLogged();
        }
    },

    data() {
        return {
            question: null,
            originalQuestionValue: '',
            editing: false
        };
    },

    async mounted() {
        this.listen();
        await this.fetchQuestion();
    },

    methods: {
        listen() {
            EventBus.$on('callEditQuestion', () => {
                this.editing = true;

                this.originalQuestionValue = this.question;
            });

            EventBus.$on('callCancelEditQuestion', question => {
                this.editing = false;

                if (question !== this.question) {
                    this.question = this.originalQuestionValue;
                    this.originalQuestionValue = '';
                }
            });
        },

        async fetchQuestion() {
            const { data } = await axios.get(
                `/api/question/${this.$route.params.slug}`
            );
            this.question = data.data;
        }
    }
};
</script>
<style></style>
