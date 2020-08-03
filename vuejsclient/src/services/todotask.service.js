import axios from 'axios';
import authHeader from './auth-header';

const API_URL = 'http://127.0.0.1:8000/api/tasks/';

class TodotaskService {

    async getAllTasksAdmin() {
        return axios.get(API_URL + 'allAdmin', { headers: authHeader() });
    }

    async getAllTasksUser() {
        return axios.get(API_URL + 'allUser', { headers: authHeader() });
    }

    async addTask(task) {
        return axios.post(API_URL + 'createTask', task, { headers: authHeader() });
    }

    async editTask(task) {
        return axios.post(API_URL + 'editTask/'+task.id, task, { headers: authHeader() });
    }

    async changeStatus(task) {
        return axios.post(API_URL + 'changeStatus/'+task.id, task, { headers: authHeader() });
    }

    async deleteTask(task) {
        return axios.delete(API_URL + 'deleteTask/'+task.id, { headers: authHeader() });
    }
}

export default new TodotaskService();
