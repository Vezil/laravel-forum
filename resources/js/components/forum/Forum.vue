<template>
    <v-container fluid grid-list-md>
        <v-layout v-if="!loading" row wrap>
            <v-flex xs8>
                <question
                    v-for="(question, index) in questions"
                    :key="index"
                    :question="question"
                >
                </question>
                <div v-if="paginationLength" class="text-center mt-4">
                    <v-pagination
                        v-model="meta.current_page"
                        :length="paginationLength"
                        @input="fetchQuestions"
                    ></v-pagination>
                </div>
            </v-flex>

            <v-flex xs4>
                <app-sidebar></app-sidebar>
            </v-flex>
        </v-layout>
        <div v-else class="d-flex justify-center my-16">
            <v-progress-circular
                :size="140"
                :width="12"
                color="purple"
                indeterminate
            ></v-progress-circular>
        </div>
    </v-container>
</template>
<script>
import Question from './Question';
import AppSidebar from './AppSidebar';
export default {
    components: {
        Question,
        AppSidebar
    },

    data() {
        return {
            questions: [],
            meta: {},
            loading: false
        };
    },

    computed: {
        paginationLength() {
            return Math.ceil(this.meta.total / this.meta.per_page);
        }
    },

    mounted() {
        this.fetchQuestions(1);
    },

    methods: {
        async fetchQuestions(page) {
            try {
                this.loading = true;

                const { data } = await axios.get(`/api/question?page=${page}`);

                this.questions = data.data;
                this.meta = data.meta;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
<style></style>
