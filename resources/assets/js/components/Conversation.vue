<template>
    <ul v-if="conversation">
        <li v-for="item in conversation.messages" class="chat-message">
            <p class="message-time"><span>{{ item.date | time }}</span></p>
            <div class="chat" :class="{me : item.self}">
                <img class="user-avatar" width="30" height="30"
                     :src="item.self ? user.img : conversation.user.img">
                <div class="text">{{item.content}}</div>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['conversation', 'user'],
        filters: {
            // Get hour:minutes from date
            time (date) {
                if (typeof date === 'string') {
                    date = new Date(date);
                }
                return date.getHours() + ':' + date.getMinutes();
            }
        }
    }
</script>
