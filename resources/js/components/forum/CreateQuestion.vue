<template>
    <v-container>
        <v-form @submit.prevent="createAsk">
            <v-text-field
                v-model="form.title"
                label="Title"
                type="text"
                required
            />

            <span v-if="errors.title" class="mt-2 red--text">
                {{ errors.title[0] }}
            </span>

            <v-select
                v-model="form.category_id"
                :items="categories"
                item-text="name"
                item-value="id"
                label="Category"
                autocomplete
            >
            </v-select>

            <span v-if="errors.category_id" class="mt-2 red--text">
                {{ errors.category_id[0] }}
            </span>

            <markdown-editor v-model="form.body" />

            <span v-if="errors.body" class="red--text">
                {{ errors.body[0] }}
            </span>

            <div class="mt-2">
                <v-btn color="green" type="submit" :disabled="isDisabled">
                    Create
                </v-btn>
            </div>
        </v-form>
    </v-container>
</template>
<script>
import markdownEditor from 'vue-simplemde/src/index';

export default {
    components: {
        markdownEditor
    },

    computed: {
        isDisabled() {
            return !(
                this.form.title &&
                this.form.body &&
                this.form.category_id
            );
        }
    },

    data() {
        return {
            categories: [],
            form: {
                title: null,
                category_id: null,
                body: null
            },
            errors: {}
        };
    },

    async mounted() {
        await this.fetchCategories();
    },

    methods: {
        async fetchCategories() {
            try {
                const { data } = await axios.get('/api/category');

                this.categories = data.data;
            } catch (error) {
                console.error(error);
            }
        },

        async createAsk() {
            try {
                const { data } = await axios.post('/api/question', this.form);

                this.$router.push(data.path);
            } catch (error) {
                console.error(error);

                if (
                    error.response &&
                    error.response.data &&
                    error.response.data.errors
                ) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
};
</script>
<style></style>
