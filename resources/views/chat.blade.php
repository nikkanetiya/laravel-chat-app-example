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
                <text :conversation="conversation"></text>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>

</html>