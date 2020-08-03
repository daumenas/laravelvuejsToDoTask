<template>
    <div>
        <h3>To-do task list</h3>
        <div class="alert alert-danger" v-if="has_error">
            <p>Error try again later</p>
        </div>
        <table class="table">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col"><a @click="sortStatus('status')" style="color: blue">Status</a></th>
                <th scope="col"><a @click="sortDate('created_at')" style="color: blue">Created_at</a></th>
            </tr>
            <tr v-for="task in tasks" :class="{editing: task == editedTask}" v-cloak v-bind:key="task.id" style="margin-bottom: 5px;">
                <th scope="row">{{ task.id }}</th>
                <td>
                    <div class="view">{{ task.name }} </div>
                    <div class="edit"><input :disabled="!currentUser.admin" type="text" v-model="task.name"/></div>
                </td>
                <td>
                    <div class="view">{{ task.description }} </div>
                    <div class="edit"><input :disabled="!currentUser.admin" type="text" v-model="task.description"/></div>
                </td>
                <td>
                    <div class="view">{{ task.status }}</div>
                    <div class="edit"><v-select :options="options" v-model="task.status"></v-select></div>
                </td>
                <td>
                    <div class="view">{{ task.created_at }} </div>
                    <div class="edit"><input :disabled="!currentUser.admin" type="text" v-model="task.created_at"/></div>
                </td>
                <td>
                    <div class="view">
                        <button @click="editData(task)">edit</button>
                    </div>
                    <div v-show="currentUser.admin" class="edit">
                        <button @click="saveData(task)">save</button>
                    </div>
                    <div v-show="!currentUser.admin" class="edit">
                        <button @click="changeStatus(task)">ChangeStatus</button>
                    </div>
                </td>
                <td><button v-show="currentUser.admin" @click="deleteData(task)">delete</button></td>
            </tr>
        </table>
        <button v-if="currentUser.admin" type="button" class="btn btn-green" @click="showModal">Add task</button>

        <task-form v-show="isModalVisible" @close="closeModal"/>
    </div>
</template>
<script>
import TodotaskService from '../services/todotask.service';
import TaskForm from './admin/TaskForm.vue'

export default {
    data() {
        return {
            options: [
                'To-Do',
                'In-Progress',
                'Done'
            ],
            has_error: false,
            isModalVisible: false,
            editMode: false,
            editedTask: '',
            tasks: [],
        }
    },
    computed: {
        currentUser() {
            return this.$store.state.auth.user;
        },
    },
    components: {
        TaskForm
    },
    async mounted() {
        if(this.currentUser.admin) {
            const response = await TodotaskService.getAllTasksAdmin();
            this.tasks = response.data.tasks;
        }
        else {
            const response = await TodotaskService.getAllTasksUser();
            this.tasks = response.data.tasks;
        }
    },
    methods: {
        showModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        },
        async saveData () {
            await TodotaskService.editTask(this.editedTask);
            this.editedTask = '';
        },
        editData (task) {
            this.beforEditCache = task
            this.editedTask = task
        },
        async deleteData (task) {
            await TodotaskService.deleteTask(task);
        },
        async changeStatus () {
            await TodotaskService.changeStatus(this.editedTask);
            this.editedTask = '';
        },
        sortStatus: function() {
            function compare(a, b) {
                if (a.status < b.status)
                    return -1;
                if (a.status > b.status)
                    return 1;
                return 0;
            }
            return this.tasks.sort(compare);
        },
        sortDate: function() {
            function compare(a, b) {
                if (new Date(a.created_at) < new Date(b.created_at))
                    return -1;
                if (new Date(a.created_at) > new Date(b.created_at))
                    return 1;
                return 0;
            }
            return this.tasks.sort(compare);
        }
    }
}
</script>
<style>
[v-cloak] {
    display: none;
}
.edit {
    display: none;
}
.editing .edit {
    display: block
}
.editing .view {
    display: none;
}
</style>
