<template>
    <transition name="modal-fade">
        <div class="modal-backdrop">
            <div class="modal"
                 role="dialog"
                 aria-labelledby="modalTitle"
                 aria-describedby="modalDescription">
                <section
                    class="modal-body"
                    id="modalDescription">
                    <slot name="body">
                        <form @submit.prevent="onSubmit">

                            <div class="form-group" v-bind:class="{ 'has-error': errors.email }">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com"
                                       v-model="user.email">
                                <span class="help-block" v-if="errors.email">{{ errors.email }}</span>
                            </div>
                            <div class="form-group" v-bind:class="{ 'has-error': errors.password }">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" v-model="user.password">
                                <span class="help-block" v-if="errors.password">{{ errors.password }}</span>
                            </div>
                            <button class="button is-primary" v-bind:class="{ 'is-loading' : isLoading }">Create User</button>
                        </form>
                    </slot>
                </section>
                <footer class="modal-footer">
                    <slot name="footer">
                        <button type="button" class="btn btn-green" @click="close" aria-label="Close modal">
                            Close
                        </button>
                    </slot>
                </footer>
            </div>
        </div>
    </transition>
</template>

<script>
import UserService from '../../services/user.service';
import User from "@/models/user";
export default {
    name: 'modal',
    data() {
        return {
            user: new User('', ''),
            isLoading: false
        }
    },

    methods: {
        onSubmit() {
            this.isLoading = true
            this.addUser()
        },
        async addUser() {
            await UserService.addUser(this.user);
            this.close();
        },
        close() {
            this.$emit('close');
        },
    },
};
</script>
<style>
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal {
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
}

.modal-header,
.modal-footer {
    padding: 15px;
    display: flex;
}

.modal-header {
    border-bottom: 1px solid #eeeeee;
    color: #4AAE9B;
    justify-content: space-between;
}

.modal-footer {
    border-top: 1px solid #eeeeee;
    justify-content: flex-end;
}

.modal-body {
    position: relative;
    padding: 20px 10px;
}

.btn-close {
    border: none;
    font-size: 20px;
    padding: 20px;
    cursor: pointer;
    font-weight: bold;
    color: #4AAE9B;
    background: transparent;
}

.btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
}
</style>
