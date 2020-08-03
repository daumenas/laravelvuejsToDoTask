import axios from 'axios';
import authHeader from './auth-header';

const API_URL = 'http://127.0.0.1:8000/api/users/';

class UserService {

    async getAllUsers() {
        return axios.get(API_URL + 'all', { headers: authHeader() });
    }

    async getUser(user) {
        return axios.get(API_URL + 'show/'+user.id, { headers: authHeader() });
    }

    async addUser(user) {
        return axios.post(API_URL + 'createUser', user, { headers: authHeader() });
    }

    async editUser(user) {
        return axios.post(API_URL + 'editUser/'+user.id, user, { headers: authHeader() });
    }

    async deleteUser(user) {
        return axios.delete(API_URL + 'deleteUser/'+user.id, { headers: authHeader() });
    }
}

export default new UserService();
