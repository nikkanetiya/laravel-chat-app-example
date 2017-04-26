<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <title>Laravel Chat App</title>

    <link rel="stylesheet" media="all" href="css/app.css">
    <script>
        window.csrfToken = "{!! csrf_token() !!}";
        window.userApiToken = "{!! auth()->user()->api_token !!}";
        window.baseUrl = "{!! url('api') !!}";
    </script>
</head>

<body>
    <div id="app">
        <div class="sidebar">
            <!-- User Listing Container -->
            <div class="me">
                <header>
                    <img class="user-avatar" width="40" height="40" :alt="me.name" :src="me.image_url">
                    <p class="user-name">@{{ me.name }}</p>
                    <div class="logout">
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </div>
                    <form id="logout-form"
                          action="{{ url('/logout') }}"
                          method="POST"
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
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
    <script src="https://js.pusher.com/4.0/pusher.min.js"></script>

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

                    if(this.currentConversation.conversations.length == 0) {
                       var that = this;

                        axios.get('conversations/' + this.conversationUserId)
                            .then(response => {

                                that.currentConversation.conversations = response.data.data.conversations;
                            }).catch(function (error) {
                                alert('Something went wrong!!');
                            });
                    }
                },
                // Add core here to trigger api later on
                sendMessage: function() {
                    var that = this;

                    axios.post('conversation', {
                            user_id: this.conversationUserId,
                            message: this.messageText
                        })
                        .then(response => {

                            // Push message to local stack
                            that.currentConversation.conversations.push({
                                message: that.messageText,
                                created_at: new Date(),
                                sender_id: that.me.id,
                                user_id: that.conversationUserId
                            });

                            that.messageText = '';
                        })
                        .catch(function (error) {
                            alert('Something went wrong!!');
                        });
                }
            }
        });
    </script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: 'ap2',
            encrypted: true
        });

        var channel = pusher.subscribe("user-{{ auth()->id() }}");
        channel.bind('conversation.received', function(response) {

            // For now, just change focus, until we don't have notification bar
            app.currentConversationId = response.conversation.sender_id;

            // Add newly received conversation
            app.currentConversation.conversations.push(response.conversation);
        });
    </script>
</body>

</html>