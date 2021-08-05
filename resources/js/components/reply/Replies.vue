<template>
    <div>
        <reply
            v-for="(reply, index) in content"
            :key="reply.id"
            :reply="reply"
            :index="index"
        />
    </div>
</template>
<script>
import Reply from './Reply';

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
            content: this.question.replies
        };
    },

    components: {
        Reply
    },

    mounted() {
        this.listen();
    },

    methods: {
        listen() {
            EventBus.$on('newReply', reply => {
                this.content.unshift(reply);
            });

            EventBus.$on('deleteReply', async index => {
                try {
                    const response = await this.$fire({
                        title: 'Are you sure ?',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        showCancelButton: true,
                        showCloseButton: false
                    });

                    if (response.value) {
                        await axios.delete(
                            `/api/question/${this.question.slug}/reply/${this.content[index].id}`
                        );

                        this.content.splice(index, 1);

                        EventBus.$emit('callChangeRepliesState', 'decrement');
                    }
                } catch (error) {
                    console.error(error);
                }
            });

            Echo.channel('create-edit-reply-channel').listen(
                'CreateEditReplyEvent',
                ({ reply, questionId, mode }) => {
                    if (questionId === this.question.id) {
                        if (mode === 'create') {
                            this.content.unshift(reply);
                        } else {
                            const index = this.content.findIndex(
                                oldReply => oldReply.id === reply.id
                            );

                            this.content[index].reply = reply.reply;
                        }
                    }
                }
            );

            Echo.channel('delete-reply-channel').listen(
                'DeleteReplyEvent',
                ({ id }) => {
                    const index = this.content.findIndex(
                        reply => reply.id === id
                    );

                    this.content.splice(index, 1);
                }
            );
        }
    }
};
</script>
<style></style>
