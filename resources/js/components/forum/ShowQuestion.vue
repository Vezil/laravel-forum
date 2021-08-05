<template>
    <v-card color="#e0e6fb">
        <v-container fluid>
            <v-card-title>
                <div>
                    <div class="headline">
                        {{ question.title }}
                    </div>
                    <span class="grey--text">
                        <small>
                            {{ question.user }} asked
                            {{ question.created_at }}
                        </small>
                    </span>
                </div>
                <v-spacer></v-spacer>
                <v-btn color="teal" dark
                    >{{ repliesCount || '0' }} Replies</v-btn
                >
            </v-card-title>

            <v-card-text v-html="body"> </v-card-text>

            <v-card-actions v-if="own">
                <v-btn icon @click="editAsk">
                    <v-icon color="orange">edit</v-icon>
                </v-btn>
                <v-btn icon @click="deleteAsk">
                    <v-icon>delete</v-icon>
                </v-btn>
            </v-card-actions>
        </v-container>
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
    },

    data() {
        return {
            own: User.own(this.question.user_id),
            repliesCount: this.question.replies_count
        };
    },

    computed: {
        body() {
            return md.parse(this.question.body);
        }
    },

    mounted() {
        this.listen();
    },

    methods: {
        listen() {
            EventBus.$on('callChangeRepliesState', value => {
                if (value === 'increment') {
                    this.repliesCount++;
                }

                if (value === 'decrement') {
                    this.repliesCount--;
                }
            });

            Echo.channel(`create-edit-reply-channel`).listen(
                'CreateReplyEvent',
                ({ questionId }) => {
                    if (questionId === this.question.id) {
                        this.repliesCount++;
                    }
                }
            );

            Echo.channel('delete-reply-channel').listen(
                'DeleteReplyEvent',
                ({ questionId }) => {
                    if (questionId === this.question.id) {
                        this.repliesCount--;
                    }
                }
            );
        },

        editAsk() {
            EventBus.$emit('callEditQuestion');
        },

        async deleteAsk() {
            try {
                const response = await this.$fire({
                    title: 'Are you sure ?',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    showCancelButton: true,
                    showCloseButton: false
                });

                if (response.value) {
                    await axios.delete(`/api/question/${this.question.slug}`);
                    this.$router.push('/forum');
                }
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>
<style></style>
