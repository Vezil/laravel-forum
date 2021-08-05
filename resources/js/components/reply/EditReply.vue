<template>
    <div>
        <markdown-editor v-model="reply.reply" />

        <v-card-actions>
            <v-btn icon @click="updateReply">
                <v-icon color="green">
                    save
                </v-icon>
            </v-btn>

            <v-btn icon @click="cancelUpdateReply">
                <v-icon color="black">
                    cancel
                </v-icon>
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
import MarkdownEditor from 'vue-simplemde/src/index';

export default {
    props: {
        reply: {
            type: Object,
            required: true,
            default: () => ({})
        }
    },

    components: {
        MarkdownEditor
    },

    methods: {
        async updateReply() {
            await axios.patch(
                `/api/question/${this.reply.question_slug}/reply/${this.reply.id}`,
                { body: this.reply.reply }
            );

            this.disableEditMode();
        },

        cancelUpdateReply(reply) {
            EventBus.$emit('cancelEditingReply', reply);
        },

        disableEditMode() {
            EventBus.$emit('disableEditMode');
        }
    }
};
</script>

<style></style>
