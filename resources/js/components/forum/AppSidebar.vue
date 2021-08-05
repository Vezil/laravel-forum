<template>
    <v-card color="#97ebdb">
        <v-toolbar dark dense class="mt-2 sidebar">
            <v-toolbar-title dark>Categories</v-toolbar-title>
        </v-toolbar>

        <v-list-item v-for="category in categories" :key="category.id">
            <v-list-item-content>
                <v-list-item-title>{{ category.name }}</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
    </v-card>
</template>
<script>
export default {
    data() {
        return {
            categories: []
        };
    },

    mounted() {
        this.fetchCategories();
    },

    methods: {
        async fetchCategories() {
            try {
                const { data } = await axios.get('/api/category');

                this.categories = data;
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>
<style>
.sidebar > .v-toolbar__content {
    background-color: rgb(28, 148, 28);
}
</style>
