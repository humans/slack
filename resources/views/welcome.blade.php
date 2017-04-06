<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <script>
         window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
         ]) !!};
        </script>
    </head>
    <body>
        <div id="app">
            <div class="channel-list">
                <h2>Channel List</h2>

                <ul>
                    <li v-for="channel in channels">
                        <a href="#" @click.prevent="join(channel)">#@{{ channel.name }}</a>
                    </li>
                </ul>
            </div>

            <div class="message-list">
                <input name="" type="text" value="" @keyup.enter="send" v-model="message">
                <ul>
                    <li v-for="message in messages">
                        @{{ message.user.name }}: @{{ message.content }}
                    </li>
                </ul>
            </div>
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
