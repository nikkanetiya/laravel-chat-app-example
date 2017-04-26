<template>
    <ul v-if="currentConversation">
        <li v-for="conversation in currentConversation.conversations" class="chat-message">
            <p class="message-time"><span>{{ conversation.created_at | time }}</span></p>
            <div class="chat" :class="{me : conversation.sender_id == me.id}">
                <img class="user-avatar" width="30" height="30"
                     :src="conversation.sender_id == me.id ? me.image_url : currentConversation.image_url">
                <div class="text">{{conversation.message}}</div>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['currentConversation', 'me'],
        filters: {
            // Get hour:minutes from date
            time (date) {
                date = new Date(date);
                return date.getHours() + ':' + date.getMinutes();
            }
        }
    }
</script>
