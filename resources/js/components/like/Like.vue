<template>
    <div>
        <v-btn icon @click="likeIt">
            <v-icon :color="likeColor">
                mdi-thumb-up
            </v-icon>
            &nbsp; {{ count }}
        </v-btn>
    </div>
</template>

<script>
export default {
    props: {
        reply: {
            type: Object,
            required: true,
            default: () => ({})
        }
    },

    data() {
        return {
            liked: this.reply.liked,
            count: this.reply.like_count
        };
    },

    computed: {
        likeColor() {
            return this.liked ? 'blue' : 'grey';
        }
    },

    mounted() {
        Echo.channel('like-channel').listen('LikeEvent', event => {
            if (this.reply.id === event.id) {
                event.type === 1 ? this.count++ : this.count--;
            }
        });
    },

    methods: {
        likeIt() {
            if (User.isLogged()) {
                this.liked ? this.decrement() : this.increment();
                this.liked = !this.liked;
            }
        },

        async increment() {
            try {
                await axios.post(`/api/like/${this.reply.id}`);

                this.count++;
            } catch (error) {
                console.error(error);
            }
        },

        async decrement() {
            try {
                await axios.delete(`/api/like/${this.reply.id}`);

                this.count--;
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>

<style></style>
