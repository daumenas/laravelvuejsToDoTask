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
                            <div class="form-group" v-bind:class="{ 'has-error': errors.name }">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" placeholder="task name"
                                       v-model="todotask.name">
                                <span class="help-block" v-if="errors.name">{{ errors.name }}</span>
                            </div>
                            <div class="form-group" v-bind:class="{ 'has-error': errors.description }">
                                <label for="description">Description</label>
                                <input type="text" id="description" class="form-control" placeholder="Task description"
                                       v-model="todotask.description">
                                <span class="help-block" v-if="errors.description">{{ errors.description }}</span>
                            </div>
                            <label>User</label>
                            <div class="form-group">
                                <select v-model="todotask.user_id">
                                    <option v-for="user in users" :value="user.id" v-bind:key="user.id">
                                        {{ user.email }}
                                    </option>
                                </select>
                                <span class="help-block" v-if="errors.user_id">{{ errors.user_id }}</span>
                            </div>
                            <div class="form-group" v-bind:class="{ 'has-error': errors.status }">
                            </div>
                            <button class="button is-primary" v-bind:class="{ 'is-loading' : isLoading }">Create Task</button>
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
import TodotaskService from '../../services/todotask.service'
import UserService from "@/services/user.service";
import ToDoTask from "@/models/todotask";
export default {
    name: 'modal',
    data() {
        return {
            todotask: new ToDoTask('','',''),
            isLoading: false,
            users: []
        }
    },
    computed: {
        currentUser() {
            return this.$store.state.auth.user;
        }
    },
    async mounted() {
        if(this.currentUser.admin)
        await UserService.getAllUsers().then(resp => this.users = resp.data.users);
    },
    methods: {
        onSubmit() {
            this.isLoading = true
            this.addTask()
        },
        async addTask() {
            await TodotaskService.addTask(this.todotask);
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
