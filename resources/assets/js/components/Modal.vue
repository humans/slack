<template>
    <div class="modal">
        <div class="modal-wrapper">
            <a class="modal-close" href="#" @click.prevent="close">
                <i class="icon">x</i>
                <span class="close-key">esc</span>
            </a>

            <header class="modal-header">
                <div>
                    <h1 class="modal-heading">
                        <slot name="heading"></slot>
                    </h1>

                    <p class="modal-description">
                        <slot name="description"></slot>
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

export default {
  methods: mapMutations({
    close: 'modal/close'
  }),
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
}
</style>
