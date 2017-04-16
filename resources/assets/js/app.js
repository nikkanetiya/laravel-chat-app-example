
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('conversation', require('./components/Conversation.vue'));

Vue.component('message-textbox', require('./components/MessageTextBox.vue'));

Vue.config.devtools = true;

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
