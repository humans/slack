<template>
    <div class="message">
        <img class="message-user-avatar" alt="User avatar" src="error">

        <div class="message-wrapper">
            <div class="message-details">
                <strong class="message-display-name">{{ message.user.username }}</strong>

                <!-- We'll add a tooltip here -->
                <a class="message-time">{{ $moment(message.created_at).format('H:mm A') }}</a>
            </div>

            <div class="message-content">
                {{ message.content }}
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    props: ['message'],
  }
</script>

<style>
.message {
    display: flex;
    padding: 0.25rem 0;
}

.message-wrapper {
    margin-left: 0.75rem;
}

.message-display-name {
}

.message-time {
    color: var(--grey);
    font-size: 0.75rem;
    font-weight: 300;
    margin-left: 0.5rem;
}

.message-user-avatar {
    border-radius: 2px;
    color: transparent;
    position: relative;

    height: 38px;
    width: 38px;
}

.message-content {
    margin-top: 0.25rem;
}

.message-user-avatar[alt]:after {
    background-color: #e8e8e8;
    content: '';

    display: block;
    width: 100%;
    height: 100%;

    position: absolute;
    top: 0;
    left: 0;
}
</style>
