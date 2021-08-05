<template>
    <v-container fluid>
        <v-card color="#e0e6fb">
            <v-form @submit.prevent="updateQuestion">
                <v-text-field
                    v-model="form.title"
                    label="Title"
                    type="text"
                    required
                />

                <markdown-editor v-model="form.body" />

                <v-card-actions>
                    <v-btn icon type="submit">
                        <v-icon color="teal">save</v-icon>
                    </v-btn>

                    <v-btn icon @click="cancelEdit">
                        <v-icon>cancel</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-container>
</template>
<script>
import markdownEditor from 'vue-simplemde/src/index';

export default {
    props: {
        question: {
            type: Object,
            required: true,
            default: () => ({})
        }
    },

    components: {
        markdownEditor
    },

    data() {
        return {
            form: {
                title: null,
                body: null
            }
        };
    },

    mounted() {
        this.form = this.question;
    },

    methods: {
        cancelEdit(question) {
            EventBus.$emit('callCancelEditQuestion', question);
        },

        async updateQuestion() {
            try {
                await axios.patch(`/api/question/${this.form.slug}`, this.form);

                await this.cancelEdit(this.form);
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>
<style></style>
