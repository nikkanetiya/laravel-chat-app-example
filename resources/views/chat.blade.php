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
                    <img class="user-avatar" width="40" height="40" :alt="user.name" :src="user.img">
                    <p class="user-name">@{{ user.name }}</p>
                </header>
            </div>
            <div class="user-list">
                <ul>
                    <li v-for="item in conversations" :class="{ active: item.id === currentConversationId }"
                    @click="selectConversation(item.id)">
                        <img class="user-avatar" width="30" height="30" :alt="item.user.name" :src="item.user.img">
                        <p class="user-name">@{{ item.user.name }}</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main">
            <!-- Main Chat Container -->
            <div class="chat-window">
                <conversation :conversation="conversation" :user="user"></conversation>
            </div>
            <div class="message">
                <message-textbox :conversation="conversation"></message-textbox>
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
                user: {
                    name: 'Nikunj',
                    img: 'images/user1.png'
                },
                // All Conversation
                conversations: [
                    {
                        id: 1,
                        user: {
                            name: 'John',
                            img: 'images/user2.png'
                        },
                        messages: [
                            {
                                content: 'Hello, Nik',
                                date: now,
                                self: false
                            }, {
                                content: 'Hello Henry',
                                date: now,
                                self: true
                            }, {
                                content: 'How are you?',
                                date: now,
                                self: false
                            }
                        ]
                    },
                    {
                        id: 2,
                        user: {
                            name: 'Henry',
                            img: 'images/user3.png'
                        },
                        messages: [
                            {
                                content: 'Hi Nik?',
                                date: now,
                                self: false
                            }
                        ]
                    }
                ],
                // Set current active chat user
                currentConversationId: 1,
                // Filter Key
                filterKey: ''
            },
            computed: {
                // Get conversation with current selected user
                conversation: function () {
                    return this.conversations.find(conversation => conversation.id == this.currentConversationId);
                }
            },
            methods: {
                // Method for selecting Conversation Session with any particular user
                selectConversation: function (id) {
                    this.currentConversationId = id;
                }
            }
        });
    </script>
</body>

</html>