<template>
    <div class="mt-4">
        <v-card>
            <v-card-title>
                <div class="headline col-9">{{ reply.user }}</div>
                <small class="col-2">
                    <div class="ml-2 caption ">
                        replied {{ reply.created_at }}
                    </div>
                </small>
                <v-spacer></v-spacer>
                <like :reply="reply" />
            </v-card-title>

            <v-divider />

            <edit-reply v-if="editing" :reply="reply" />

            <v-card-text v-else v-html="replyData"></v-card-text>

            <div v-if="!editing">
                <v-card-actions v-if="own">
                    <v-btn icon @click="editReply">
                        <v-icon color="orange">
                            edit
                        </v-icon>
                    </v-btn>

                    <v-btn icon @click="removeReply">
                        <v-icon>
                            delete
                        </v-icon>
                    </v-btn>
                </v-card-actions>
            </div>
        </v-card>
    </div>
</template>

<script>
import EditReply from './EditReply';
import Like from '../like/Like';

export default {
    props: {
        reply: {
            type: Object,
            required: true,
            default: () => ({})
        },
        index: {
            type: Number,
            required: true,
            default: null
        }
    },

    components: {
        EditReply,
        Like
    },

    data() {
        return {
            editing: false,
            originalReplyValue: ''
        };
    },

    mounted() {
        this.listen();
    },

    computed: {
        own() {
            return User.own(this.reply.user_id);
        },

        replyData() {
            return md.parse(this.reply.reply);
        }
    },

    methods: {
        listen() {
            EventBus.$on('cancelEditingReply', reply => {
                if (this.originalReplyValue) {
                    this.reply.reply = this.originalReplyValue;
                    this.originalReplyValue = '';
                }

                this.disableEditMode();
            });

            EventBus.$on('disableEditMode', () => {
                this.disableEditMode();
            });
        },

        removeReply() {
            EventBus.$emit('deleteReply', this.index);
        },

        editReply() {
            this.editing = true;
            this.originalReplyValue = this.reply.reply;
        },

        disableEditMode() {
            this.editing = false;
        }
    }
};
</script>

<style></style>
