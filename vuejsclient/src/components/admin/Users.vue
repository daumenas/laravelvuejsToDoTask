<template>
    <div>
        <h3>User list</h3>
        <div class="alert alert-danger" v-if="has_error">
            <p>Error try again later</p>
        </div>
        <table class="table">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Role</th>
                <th scope="col">Email</th>
            </tr>
            <tr v-for="user in users" :class="{editing: user == editedUser}" v-cloak v-bind:key="user.id" style="margin-bottom: 5px;">
                <th scope="row">{{ user.id }}</th>
                <td>
                    <div class="view">{{ user.name }} </div>
                    <div class="edit"><input type="text" v-model="user.name"/></div>
                </td>
                <td>
                    <div class="view">{{ user.role }} </div>
                    <div class="edit"><input type="text" v-model="user.role"/></div>
                </td>
                <td>
                    <div class="view">{{ user.email }}</div>
                    <div class="edit"><input type="text" v-model="user.email"/></div>
                </td>
                <td>
                    <div class="view">
                        <button @click="editData(user)">edit</button>
                    </div>
                    <div class="edit">
                        <button @click="saveData(user)">save</button>
                    </div>
                </td>
                <td><button @click="deleteData(user)">delete</button></td>
            </tr>
        </table>
        <button type="button" class="btn btn-green" @click="showModal">Add user</button>

        <user-form v-show="isModalVisible" @close="closeModal"/>
    </div>
</template>
<script>
import UserService from '../../services/user.service';
import UserForm from './UserForm.vue'

export default {
    data() {
        return {
            has_error: false,
            users: null,
            isModalVisible: false,
            editMode: false,
            editedUser: ''
        }
    },
    components: {
        UserForm
    },
    async mounted() {
        const response = await UserService.getAllUsers();
        this.users = response.data.users;
    },
    methods: {
        showModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        },
        async saveData () {
            await UserService.editUser(this.editedUser);
            this.editedUser = '';
        },
        editData (user) {
            this.beforEditCache = user
            this.editedUser = user
        },
        async deleteData (user) {
            await UserService.deleteUser(user);
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
