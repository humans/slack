
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

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',

    data: {
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
            this.currentChannel = channel;

            this.subscription = window.Echo.channel(channel.name);
        },

        send () {
            window.axios
                .post(`/api/channels/${this.currentChannel.id}/messages`)
                .then(({ data }) => {
                    this.messages = this.messages.concat(data);
                })

            this.message = null;
        },

        refresh () {
            window.axios
                .get('/api/channels')
                .then(({ data }) => this.channels = data);
        },
    },
});
