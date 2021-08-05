<template>
    <div class="text-center">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    icon
                    slot="activator"
                    :color="notificationsLength ? 'red' : 'gray'"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon>add_alert</v-icon>
                    <span
                        v-if="notificationsLength"
                        class="notificationsLength"
                    >
                        {{ notificationsLength }}
                    </span>
                </v-btn>
            </template>
            <v-list>
                <v-list-item
                    v-for="(notification, index) in notifications"
                    :key="`unread-${index}`"
                >
                    <router-link :to="notification.path">
                        <v-list-item-title
                            @click="readNotification(notification, index)"
                        >
                            <b>New reply in </b>:
                            {{ notification.question }}
                        </v-list-item-title>
                    </router-link>
                </v-list-item>

                <v-divider v-if="notifications.length" />

                <v-list-item
                    v-for="(notification, index) in readNotifications"
                    :key="`read-${index}`"
                >
                    <v-list-item-title style="color:gray;">
                        <b>New reply in </b>:
                        {{ notification.question }}
                    </v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
export default {
    data() {
        return {
            notifications: [],
            readNotifications: [],
            notificationsLength: 0,
            soundNotification:
                'https://notificationsounds.com/storage/sounds/file-sounds-1154-done-for-you.mp3'
        };
    },

    mounted() {
        if (User.isLogged()) {
            this.getNotifications();
        }

        Echo.private(`App.User.${User.id()}`).notification(notification => {
            this.playSound();

            this.notifications.unshift(notification);
            this.notificationsLength++;
        });
    },

    methods: {
        async getNotifications() {
            try {
                const { data } = await axios.get('api/notifications');

                this.notifications = data.unreadNotifications;
                this.readNotifications = data.readNotifications;
                this.notificationsLength = this.notifications.length;
            } catch (error) {
                Exception.handle(error);
            }
        },
        async readNotification(notification, index) {
            try {
                const { data } = await axios.post(
                    '/api/notifications/mark-as-read',
                    {
                        id: notification.id
                    }
                );

                this.notifications.splice(index, 1);

                this.readNotifications.push(notification);
                this.notificationsLength--;
            } catch (error) {
                console.error(error);
            }
        },
        playSound() {
            const sound = new Audio(this.soundNotification);

            sound.muted = false;

            sound.play();
        }
    }
};
</script>
<style scoped>
.notificationsLength {
    color: black;
    font-size: 12px;
}
</style>
