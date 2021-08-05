<template>
    <v-container>
        <v-form @submit.prevent="addEditCategory">
            <v-text-field v-model="form.name" label="Category Name" required />

            <v-btn
                v-if="editSlug"
                type="submit"
                :disabled="isDisabled"
                color="orange"
            >
                Update
            </v-btn>
            <v-btn v-else type="submit" :disabled="isDisabled" color="teal">
                Create
            </v-btn>
        </v-form>

        <v-alert v-if="errors" type="error" :value="true" class="mt-5">
            Category name is required
        </v-alert>

        <v-card>
            <v-toolbar dark dense class="mt-8 sidebar">
                <v-toolbar-title>Categories</v-toolbar-title>
            </v-toolbar>

            <div v-for="(category, index) in categories" :key="index">
                <v-list-item>
                    <v-list-item-action>
                        <v-btn icon @click="editCategory(index)">
                            <v-icon color="orange">edit</v-icon>
                        </v-btn>
                    </v-list-item-action>

                    <v-list-item-content>
                        <v-list-item-title>{{
                            category.name
                        }}</v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-action>
                        <v-btn
                            icon
                            @click="removeCategory(index, category.slug)"
                        >
                            <v-icon>delete</v-icon>
                        </v-btn>
                    </v-list-item-action>
                </v-list-item>

                <v-divider />
            </div>
        </v-card>
    </v-container>
</template>
<script>
export default {
    computed: {
        isDisabled() {
            return !this.form.name;
        }
    },

    data() {
        return {
            categories: [],
            editSlug: null,
            editingMode: false,
            form: {
                name: null
            },
            errors: null
        };
    },

    async mounted() {
        await this.fetchCategories();
    },

    methods: {
        async addEditCategory() {
            this.editSlug
                ? await this.updateCategory()
                : await this.createCategory();
        },

        async createCategory() {
            try {
                const { data } = await axios.post('/api/category', this.form);

                this.categories.unshift(data.category);

                this.form.name = null;
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
        },

        async updateCategory() {
            try {
                const { data } = await axios.patch(
                    `/api/category/${this.editSlug}`,
                    this.form
                );

                this.categories.unshift(data);

                this.editingMode = false;
                this.editSlug = false;
                this.form.name = null;
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
        },

        async fetchCategories() {
            try {
                const { data } = await axios.get('/api/category');

                this.categories = data.data;
            } catch (error) {
                console.error(error);
            }
        },

        editCategory(index) {
            if (this.editingMode) {
                return;
            }

            this.editingMode = true;
            this.form.name = this.categories[index].name;
            this.editSlug = this.categories[index].slug;
            this.categories.splice(index, 1);
        },

        async removeCategory(index, slug) {
            try {
                const response = await this.$fire({
                    title: 'Are you sure ?',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    showCancelButton: true,
                    showCloseButton: false
                });

                if (response.value) {
                    await axios.delete(`/api/category/${slug}`, this.form);

                    this.categories.splice(index, 1);
                }
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>
<style></style>
