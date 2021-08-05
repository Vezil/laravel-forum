<template>
    <div class="mt-4">
        <markdown-editor v-if="renderMarkdown" v-model="body" />
        <v-btn color="green" dark @click="addReply">
            Reply
        </v-btn>
    </div>
</template>

<script>
import MarkdownEditor from 'vue-simplemde/src/index';

export default {
    props: {
        questionSlug: {
            type: String,
            required: true,
            default: ''
        }
    },

    components: {
        MarkdownEditor
    },

    data() {
        return {
            body: null,
            renderMarkdown: true
        };
    },

    methods: {
        async addReply() {
            try {
                const { data } = await axios.post(
                    `/api/question/${this.questionSlug}/reply`,
                    {
                        body: this.body
                    }
                );

                this.renderMarkdown = false;

                this.$nextTick(() => {
                    this.body = '';
                    this.renderMarkdown = true;
                });

                EventBus.$emit('newReply', data.reply);
                EventBus.$emit('callChangeRepliesState', 'increment');
                window.scrollTo(0, 0);
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>

<style></style>
