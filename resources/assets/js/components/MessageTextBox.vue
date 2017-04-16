<template>
    <textarea v-model="messageText" @keyup.enter="sendMessage" placeholder="Press Enter to send message"></textarea>
</template>

<script>
    export default {
        props: ['conversation'],
        data: function () {
            return {
                messageText: ''
            }
        },
        methods: {
            sendMessage: function() {
                this.conversation.messages.push({
                    content: this.messageText,
                    date: new Date(),
                    self: true
                });
                this.messageText = '';
            }
        }
    }
</script>
