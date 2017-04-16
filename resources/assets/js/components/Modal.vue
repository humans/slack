<template>
    <div class="modal">
        <div class="modal-wrapper">
            <a class="modal-close" href="#" @click.prevent="close">
                <i class="icon">&times;</i>
                <span class="close-key">esc</span>
            </a>

            <header class="modal-header">
                <div>
                    <h1 class="modal-heading">
                        <slot name="heading"></slot>
                    </h1>

                    <p class="modal-note">
                        <slot name="note"></slot>
                    </p>
                </div>

                <div class="nav right">
                    <slot name="controls"></slot>
                </div>
            </header>

            <div class="modal-body">
                <form @submit.prevent="submit">
                    <slot></slot>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { mapMutations } from 'vuex';
import Mousetrap from 'mousetrap';

export default {
  methods: mapMutations({
    close: 'modal/close',
  }),

  mounted () {
    Mousetrap.bind('esc', () => this.close());
  },
};
</script>

<style>
.modal {
    background-color: white;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
}

.modal-wrapper {
    margin: 0 auto;
    max-width: 40rem;
    position: relative;
}

.modal-close {
    border-radius: 50%;
    background-color: #e8e8e8;
    color: #717274;
    height: 4rem;
    width: 4rem;

    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-decoration: none;

    position: absolute;
    top: 2rem;
    right: 0;
}

.modal-close .icon {
    display: block;
    font-size: 2.4rem;
    font-style: normal;
    line-height: 0.8;
}

.modal-close .close-key {
    font-size: 0.75rem;
}

.modal-heading {
    font-weight: 900;
}

.modal-header {
    margin-top: 6rem;
}
</style>
