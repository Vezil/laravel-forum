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
                        v-model="current_page"
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
            loading: false,
            total: 0,
            per_page: 0,
            current_page: 0
        };
    },

    computed: {
        paginationLength() {
            return Math.ceil(this.total / this.per_page);
        }
    },

    mounted() {
        this.fetchQuestions(1);
    },

    methods: {
        async fetchQuestions(page) {
            try {
                this.loading = true;

                const { data: questions } = await axios.get(
                    `/api/question?page=${page}`
                );

                this.questions = questions.data;
                this.total = questions.total;
                this.per_page = questions.per_page;
                this.current_page = questions.current_page;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
