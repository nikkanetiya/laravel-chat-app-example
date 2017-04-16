<template>

</template>

<script>
    export default {
        props: ['currentConversation'],
        data: function () {
            return {
                messageText: ''
            }
        },
        methods: {
            sendMessage: function() {
                this.currentConversation.conversations.push({
                    message: this.messageText,
                    created_at: new Date()
                });
                this.messageText = '';
            }
        }
    }
</script>
