<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <title>Laravel Chat App</title>

    <link rel="stylesheet" media="all" href="css/app.css">
</head>

<body>
    <div id="app">
        <div class="sidebar">
            <!-- User Listing Container -->
            <div class="me">
                <header>
                    <img class="user-avatar" width="40" height="40" :alt="me.name" :src="me.image_url">
                    <p class="user-name">@{{ me.name }}</p>
                </header>
            </div>
            <div class="user-list">
                <ul>
                    <li v-for="user in users" :class="{ active: user.id === conversationUserId }"
                    @click="selectConversation(user.id)">
                        <img class="user-avatar" width="30" height="30" :alt="user.name" :src="user.image_url">
                        <p class="user-name">@{{ user.name }}</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main">
            <!-- Main Chat Container -->
            <div class="chat-window">
                <conversation :current-conversation="currentConversation" :me="me"></conversation>
            </div>
            <div class="message">
                <textarea v-show="conversationUserId" v-model="messageText" @keyup.enter="sendMessage" placeholder="Press Enter to send message"></textarea>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
    <script>
        const now = new Date();

        const app = new Vue({
            el: '#app',
            data: {
                // Current User
                me: {!! $user->toJSON() !!},
                // All Conversation
                users: {!! $userWithConversations->toJSON() !!},
                // Set current active chat user
                conversationUserId: null,
                messageText: '',
                // Filter Key, for filter purpose
                filterKey: ''
            },
            computed: {
                // Get conversation with current selected user
                currentConversation: function () {
                    return this.users.find(currentConversation => currentConversation.id == this.conversationUserId);
                }
            },
            methods: {
                // Method for selecting Conversation Session with any particular user
                selectConversation: function (id) {
                    this.conversationUserId = id;
                },
                // Add message in conversations stack, just push to javascript object for now
                // Add core here to trigger api later on
                sendMessage: function() {
                    this.currentConversation.conversations.push({
                        message: this.messageText,
                        created_at: new Date(),
                        sender_id: this.conversationUserId,
                        user_id: this.me.id
                    });
                    this.messageText = '';
                }
            }
        });
    </script>
</body>

</html>