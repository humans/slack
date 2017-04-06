@extends('layouts.app')

@section('content')
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
@endsection
