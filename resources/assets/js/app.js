
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and 
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    data: {
        team: window.Laravel.team,

        channels: [],
        messages: [],

        message: null,
        currentChannel: null,
        subscription: null,
    },

    mounted () {
        this.refresh();
    },

    methods: {
        join (channel) {
            if (this.currentChannel) {
                window.Echo.leave(this.currentChannel.name);
            }

            this.messages = [];
            this.currentChannel = channel;

            window.axios
                .get(`/api/channels/${this.currentChannel.id}`)
                .then(({ data }) => this.messages = data.latest_messages);

            window.Echo
                .private(`${this.team}.channel.${channel.name}`)
                .listen('MessageSent', ({ message }) => {
                    this.messages.push(message);
                });
        },

        send () {
            window.axios
                .post(`/api/channels/${this.currentChannel.id}/messages`, { message: this.message })
                .then(({ data }) => this.messages.push(data));

            this.message = null;
        },

        refresh () {
            window.axios
                .get('/api/channels')
                .then(({ data }) => {
                    this.channels = data;

                    this.join(data[0]);
                });
        },
    },
});
